<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    // Create a temporary test directory
    $this->testDir = storage_path('framework/testing/log-insights-test');
    if (! File::exists($this->testDir)) {
        File::makeDirectory($this->testDir, 0755, true);
    }

    // Configure the command to scan our test directory
    Config::set('lalo.insights.scan_directories', [
        'storage/framework/testing/log-insights-test',
    ]);
});

afterEach(function () {
    // Clean up test directory
    if (File::exists($this->testDir)) {
        File::deleteDirectory($this->testDir);
    }
});

test('command analyzes log usage and displays statistics correctly', function () {

    File::put(
        $this->testDir.'/controller.php',
        '<?php
        Log::info("User logged in successfully");
        Log::error("Payment failed");
        Log::debug("Processing request data");'
    );

    File::put(
        $this->testDir.'/service.php',
        '<?php
        Log::warning("Deprecated method called");
        Log::info("Order processed successfully");
        Log::critical("Database connection failed");'
    );

    $this->artisan('lalo:insights')
        ->expectsOutputToContain('Log Usage Summary')
        ->expectsOutputToContain('info')
        ->expectsOutputToContain('2') // 2 info logs
        ->expectsOutputToContain('error')
        ->expectsOutputToContain('debug')
        ->expectsOutputToContain('warning')
        ->expectsOutputToContain('critical')
        ->expectsOutputToContain('Total log calls: 6')
        ->assertExitCode(0);
});
