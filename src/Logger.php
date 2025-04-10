<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator;

use Aagjalpankaj\LaravelLogValidator\Formatters\AppEnvFormatter;
use Aagjalpankaj\LaravelLogValidator\Formatters\AppNameFormatter;
use Aagjalpankaj\LaravelLogValidator\Processors\AppEnvProcessor;
use Aagjalpankaj\LaravelLogValidator\Processors\AppNameProcessor;
use Aagjalpankaj\LaravelLogValidator\Processors\Processor;
use Illuminate\Log\Logger as LaravelLogger;
use Monolog\LogRecord;

final class Logger
{
    public function __invoke(LaravelLogger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(function ($record): LogRecord {
                $appNameFormatter = new AppNameFormatter;
                $appEnvFormatter = new AppEnvFormatter;
                $record = $appNameFormatter->format($record);

                return $appEnvFormatter->format($record);
            });
        }

        $logger->pushProcessor(new Processor);
        if (config('laravel-log-validator.metadata.include_app_name', true)) {
            $logger->pushProcessor(new AppNameProcessor);
        }

        if (config('laravel-log-validator.metadata.include_app_env', true)) {
            $logger->pushProcessor(new AppEnvProcessor);
        }
    }
}
