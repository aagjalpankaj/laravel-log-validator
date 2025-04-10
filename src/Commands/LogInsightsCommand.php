<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class LogInsightsCommand extends Command
{
    protected $signature = 'lalo:insights';

    protected $description = 'Analyze log usage';

    private array $logMethods = ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'];

    private array $counts = [];

    public function handle(): void
    {
        $this->output->title('Log Usage Analysis');

        $directories = Config::get('lalo.insights.scan_directories', ['app']);
        $this->initializeCounts();
        $totalFiles = 0;
        $allFiles = [];

        foreach ($directories as $directory) {
            $path = base_path($directory);
            if (! File::isDirectory($path)) {
                $this->output->warning("Directory not found: {$directory}");

                continue;
            }

            $this->output->section("Analyzing log usage in the {$directory} directory...");
            $files = File::allFiles($path);
            $totalFiles += count($files);
            $allFiles = array_merge($allFiles, $files);
        }

        $progressBar = $this->output->createProgressBar($totalFiles);
        $progressBar->start();

        foreach ($allFiles as $file) {
            $this->analyzeFile($file);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->output->newLine(2);

        $this->displayResults();
    }

    private function initializeCounts(): void
    {
        foreach ($this->logMethods as $method) {
            $this->counts[$method] = 0;
        }
    }

    private function analyzeFile(SplFileInfo $file): void
    {
        $content = $file->getContents();

        foreach ($this->logMethods as $method) {
            $this->counts[$method] += substr_count($content, "Log::$method(");
        }
    }

    private function displayResults(): void
    {
        $this->output->section('Log Usage Summary');

        $rows = [];
        $totalLogs = 0;
        foreach ($this->logMethods as $method) {
            $count = $this->counts[$method];
            $totalLogs += $count;
            $rows[] = [$this->colorizeMethod($method), $count, $this->getPercentage($count, $totalLogs)];
        }

        $this->table(['Log Level', 'Count', 'Percentage'], $rows);

        $this->output->newLine();
        $this->info("Total log calls: $totalLogs");
    }

    private function colorizeMethod(string $method): string
    {
        $colors = [
            'emergency' => 'red',
            'alert' => 'red',
            'critical' => 'red',
            'error' => 'red',
            'warning' => 'yellow',
            'notice' => 'yellow',
            'info' => 'green',
            'debug' => 'blue',
        ];

        return "<fg={$colors[$method]}>{$method}</>";
    }

    private function getPercentage(int $count, int $total): string
    {
        if ($total === 0) {
            return '0.00%';
        }

        return number_format(($count / $total) * 100, 2).'%';
    }
}
