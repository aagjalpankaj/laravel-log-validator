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
        $logger = new MonologLogger('custom');

        $logger->pushHandler(new StreamHandler(storage_path('logs/custom.log')));

        $logger->pushProcessor(new Processor($config));

        return $logger;
    }
}
