<?php

namespace Aagjalpankaj\LaravelLogValidator\Processors;

use Aagjalpankaj\LaravelLogValidator\Validators\LogMessageValidator;
use Monolog\LogRecord;

readonly class Processor
{
    public function __construct(public array $config) {}

    public function __invoke(LogRecord $record): LogRecord
    {
        (new LogMessageValidator)->validate($record);

        return $record;
    }
}
