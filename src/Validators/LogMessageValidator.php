<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Validators;

use Aagjalpankaj\LaravelLogValidator\Exceptions\UnprocessableLogException;
use Monolog\LogRecord;

final class LogMessageValidator
{
    private int $maxLength = 50;

    private string $pattern = '/^[A-Z][a-zA-Z0-9\s.\-_:]+$/';

    public function validate(LogRecord $record): bool
    {
        if (strlen($record->message) > $this->maxLength) {
            throw new UnprocessableLogException(
                "Log message exceeds maximum length of {$this->maxLength} characters"
            );
        }

        if (in_array(preg_match($this->pattern, $record->message), [0, false], true)) {
            throw new UnprocessableLogException(
                'Log message must start with capital letter and contain only alphanumeric characters, spaces, and basic punctuation'
            );
        }

        return true;
    }
}
