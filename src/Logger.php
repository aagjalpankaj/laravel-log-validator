<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo;

use Aagjalpankaj\Lalo\Formatters\AppEnvFormatter;
use Aagjalpankaj\Lalo\Formatters\AppNameFormatter;
use Aagjalpankaj\Lalo\Processors\AppEnvProcessor;
use Aagjalpankaj\Lalo\Processors\AppNameProcessor;
use Aagjalpankaj\Lalo\Processors\Processor;
use Aagjalpankaj\Lalo\Processors\RequestIdProcessor;
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
        if (config('lalo.log_meta.include_app_name', true)) {
            $logger->pushProcessor(new AppNameProcessor);
        }

        if (config('lalo.log_meta.include_app_env', true)) {
            $logger->pushProcessor(new AppEnvProcessor);
        }

        if (config('lalo.log_meta.include_request_id', true)) {
            $logger->pushProcessor(new RequestIdProcessor);
        }
    }
}
