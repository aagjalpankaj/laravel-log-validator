<?php

namespace Aagjalpankaj\LaravelLogValidator;

use Aagjalpankaj\LaravelLogValidator\Processors\Processor;
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
                $handler->setFormatter($formatter);
            }

        } else {
            $path = $config['path'] ?? storage_path('logs/custom.log');
            $handler = new StreamHandler($path);
        }

        $logger->pushHandler($handler);

        $logger->pushProcessor(new Processor($config));

        if (isset($config['processors']) && is_array($config['processors'])) {
            foreach ($config['processors'] as $processorClass) {
                $processor = new $processorClass;
                $logger->pushProcessor($processor);
            }
        }

        return $logger;
    }
}
