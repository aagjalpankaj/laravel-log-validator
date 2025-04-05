<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Processors;

use Aagjalpankaj\LaravelLogValidator\Validators\LogContextValidator;
use Aagjalpankaj\LaravelLogValidator\Validators\LogMessageValidator;
use Monolog\LogRecord;

readonly class Processor
{
    public function __construct(public array $config) {}

    public function __invoke(LogRecord $record): LogRecord
    {
        (new LogMessageValidator)->validate($record);
        (new LogContextValidator)->validate($record);

        return $record;
    }
}
