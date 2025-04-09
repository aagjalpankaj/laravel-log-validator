<?php

declare(strict_types=1);

use Aagjalpankaj\LaravelLogValidator\Logger;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\TestHandler;

test('log meta has app name and environment', function () {
    $testHandler = new TestHandler;

    // Create a Monolog logger and handler
    $monolog = new \Monolog\Logger('test');
    $monolog->pushHandler($testHandler);

    // Create a Laravel Logger wrapping the Monolog instance
    $logger = new \Illuminate\Log\Logger($monolog);

    // Apply the Logger tap to the Laravel logger
    $loggerTap = new Logger;
    $loggerTap->__invoke($logger);

    Log::swap($logger);

    $message = 'Test log message';
    $context = ['key' => 'value'];

    Log::info($message, $context);

    $records = $testHandler->getRecords();

    $lastRecord = $records[0];
    expect($lastRecord['extra'])->toHaveKeys(['app_name', 'app_env'])
        ->and(strtolower($lastRecord['extra']['app_name']))->toBe(strtolower(config('app.name')))
        ->and(strtolower($lastRecord['extra']['app_env']))->toBe(strtolower(config('app.env')));
});
