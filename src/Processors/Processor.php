<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Processors;

use Aagjalpankaj\Lalo\Validators\LogContextValidator;
use Aagjalpankaj\Lalo\Validators\LogMessageValidator;
use Monolog\LogRecord;
use Throwable;

readonly class Processor
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $currentEnv = app()->environment();
        $validateOnlyOn = config('lalo.validate_only_on', ['local', 'testing', 'staging']);

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
