<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Validators;

use Aagjalpankaj\LaravelLogValidator\Exceptions\UnprocessableLogException;
use Monolog\LogRecord;

final class LogContextValidator
{
    private int $maxFields = 10;

    public function validate(LogRecord $record): bool
    {
        $context = $record->context;

        if (count($context) > $this->maxFields) {
            throw new UnprocessableLogException('Log context cannot have more than 10 fields');
        }

        return true;
    }
}
