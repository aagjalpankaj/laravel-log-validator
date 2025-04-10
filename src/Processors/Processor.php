<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Processors;

use Aagjalpankaj\LaravelLogValidator\Validators\LogContextValidator;
use Aagjalpankaj\LaravelLogValidator\Validators\LogMessageValidator;
use Monolog\LogRecord;
use Throwable;

readonly class Processor
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $currentEnv = app()->environment();
        $validateOnlyOn = config('laravel-log-validator.validate_only_on', ['local', 'testing', 'staging']);

        if (! in_array($currentEnv, $validateOnlyOn)) {
            return $record;
        }

        if (isset($record->context['exception']) && $record->context['exception'] instanceof Throwable) {
            return $record;
        }

        (new LogMessageValidator)->validate($record);
        (new LogContextValidator)->validate($record);

        return $record;
    }
}
