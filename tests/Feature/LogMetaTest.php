<?php

declare(strict_types=1);

use Aagjalpankaj\LaravelLogValidator\Logger;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\TestHandler;

test('log meta has app name and environment', function () {
    $testHandler = new TestHandler;

    $config = [
        'name' => 'test',
        'path' => 'php://memory',
        'level' => 'debug',
    ];

    $logger = (new Logger)($config);
    $logger->pushHandler($testHandler);

    Log::swap($logger);

    $message = 'Test log message';
    $context = ['key' => 'value'];

    Log::info($message, $context);

    $records = $testHandler->getRecords();
    expect($records)->toHaveCount(1);

    $lastRecord = $records[0];
    expect($lastRecord['extra'])->toHaveKeys(['app_name', 'app_env'])
        ->and($lastRecord['extra']['app_name'])->toBe(config('app.name'))
        ->and($lastRecord['extra']['app_env'])->toBe(config('app.env'));
});
