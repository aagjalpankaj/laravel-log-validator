<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator;

use Aagjalpankaj\LaravelLogValidator\Formatters\AppEnvFormatter;
use Aagjalpankaj\LaravelLogValidator\Formatters\AppNameFormatter;
use Aagjalpankaj\LaravelLogValidator\Processors\AppEnvProcessor;
use Aagjalpankaj\LaravelLogValidator\Processors\AppNameProcessor;
use Aagjalpankaj\LaravelLogValidator\Processors\Processor;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;
use Psr\Log\LoggerInterface;

final class Logger
{
    public function __invoke(array $config): LoggerInterface
    {
        $logger = new MonologLogger($config['name'] ?? 'custom');

        if (isset($config['handler'])) {
            $handlerClass = $config['handler'];
            $handlerParams = $config['with'] ?? [];
            $handler = new $handlerClass(...array_values($handlerParams));

            if (isset($config['formatter'])) {
                $formatterClass = $config['formatter'];
                $formatter = new $formatterClass;
            } else {
                // Use LineFormatter as default
                $formatter = new LineFormatter(null, null, true, true);
            }
        } else {
            $path = $config['path'] ?? storage_path('logs/custom.log');
            $handler = new StreamHandler($path);
            $formatter = new LineFormatter(null, null, true, true);
        }

        // Apply the formatter
        $handler->setFormatter($formatter);

        // Apply custom formatters as processors
        $handler->pushProcessor(function ($record): \Monolog\LogRecord {
            $appNameFormatter = new AppNameFormatter;
            $appEnvFormatter = new AppEnvFormatter;
            $record = $appNameFormatter->format($record);

            return $appEnvFormatter->format($record);
        });

        $logger->pushHandler($handler);

        $logger->pushProcessor(new Processor($config));
        $logger->pushProcessor(new AppNameProcessor);
        $logger->pushProcessor(new AppEnvProcessor);

        if (isset($config['processors']) && is_array($config['processors'])) {
            foreach ($config['processors'] as $processorClass) {
                $processor = new $processorClass;
                $logger->pushProcessor($processor);
            }
        }

        return $logger;
    }
}
