<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Validators;

use Aagjalpankaj\Lalo\Contracts\ValidatorInterface;
use Aagjalpankaj\Lalo\Exceptions\UnprocessableLogException;
use Monolog\LogRecord;

final class LogMessageValidator implements ValidatorInterface
{
    public function validate(LogRecord $record): bool
    {
        $maxLength = config('lalo.log_message.max_length', 50);
        $pattern = '/^[A-Z][a-zA-Z0-9\s.\-_:]+$/';

        if (strlen($record->message) > $maxLength) {
            throw new UnprocessableLogException(
                "Log message exceeds maximum length of {$maxLength} characters"
            );
        }

        if (in_array(preg_match($pattern, $record->message), [0, false], true)) {
            throw new UnprocessableLogException(
                'Log message must start with capital letter and contain only alphanumeric characters, spaces, and basic punctuation'
            );
        }

        return true;
    }
}
