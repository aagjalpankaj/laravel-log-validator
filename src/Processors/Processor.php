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
        // Skip validation if current environment is not in the validate_only_on list
        $currentEnv = app()->environment();
        $validateOnlyOn = config('laravel-log-validator.validate_only_on', ['local', 'testing', 'staging']);

        if (! in_array($currentEnv, $validateOnlyOn)) {
            return $record;
        }

        (new LogMessageValidator)->validate($record);
        (new LogContextValidator)->validate($record);

        return $record;
    }
}
