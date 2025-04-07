<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class AppEnvProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['app_env'] = config('app.env');

        return $record;
    }
}
