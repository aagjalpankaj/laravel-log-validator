<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class LogInsightsCommand extends Command
{
    protected $signature = 'log:insights';

    protected $description = 'Analyze log usage';

    private array $logMethods = ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'];

    private array $counts = [];

    public function handle(): void
    {
        $this->info('Analyzing log usage in the app directory...');

        $files = File::allFiles(app_path());
        $this->initializeCounts();

        foreach ($files as $file) {
            $this->analyzeFile($file);
        }

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
        $this->info('Log usage summary:');
        $rows = [];
        foreach ($this->logMethods as $method) {
            $rows[] = [$method, $this->counts[$method]];
        }
        $this->table(['Log Level', 'Count'], $rows);
    }
}
