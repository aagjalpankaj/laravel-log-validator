<?php

declare(strict_types=1);

use Aagjalpankaj\Lalo\Logger;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\TestHandler;

test('log meta - app name, env and request id', function () {
    $testHandler = new TestHandler;

    $monolog = new \Monolog\Logger('test');
    $monolog->pushHandler($testHandler);

    $logger = new \Illuminate\Log\Logger($monolog);

    $loggerTap = new Logger;
    $loggerTap->__invoke($logger);

    Log::swap($logger);

    $message = 'Test log message';
    $context = ['key' => 'value'];

    Log::info($message, $context);

    $records = $testHandler->getRecords();

    $lastRecord = $records[0];
    expect($lastRecord['extra'])->toHaveKeys(['app_name', 'app_env', 'request_id'])
        ->and(strtolower($lastRecord['extra']['app_name']))->toBe(strtolower(config('app.name')))
        ->and(strtolower($lastRecord['extra']['app_env']))->toBe(strtolower(config('app.env')))
        ->and($lastRecord['extra']['request_id'])->toStartWith('cli-');
});
