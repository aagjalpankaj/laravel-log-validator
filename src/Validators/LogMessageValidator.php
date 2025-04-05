<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Validators;

use Aagjalpankaj\LaravelLogValidator\Exceptions\UnprocessableLogException;
use Monolog\LogRecord;

final class LogMessageValidator
{
    private int $maxLength = 50;

    public function validate(LogRecord $record): bool
    {
        if (strlen($record->message) > $this->maxLength) {
            throw new UnprocessableLogException(
                "Log message exceeds maximum length of {$this->maxLength} characters"
            );
        }

        return true;
    }
}
