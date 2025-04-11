<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Validators;

use Aagjalpankaj\Lalo\Contracts\ValidatorInterface;
use Aagjalpankaj\Lalo\Exceptions\UnprocessableLogException;
use Monolog\LogRecord;

final class LogContextValidator implements ValidatorInterface
{
    public function validate(LogRecord $record): bool
    {
        $context = $record->context;

        $maxFields = config('lalo.log_context.max_fields', 10);

        if (count($context) > $maxFields) {
            throw new UnprocessableLogException("Log context cannot have more than $maxFields fields");
        }

        foreach ($context as $key => $value) {
            if (! $this->isValidCamelCase($key)) {
                throw new UnprocessableLogException("Context key '$key' must be in camelCase format");
            }

            if (! $this->isValidContextValue($value)) {
                throw new UnprocessableLogException("Context value for key '$key' must be a scalar, null, or an array of scalars");
            }
        }

        return true;
    }

    private function isValidCamelCase(string $key): bool
    {
        return preg_match('/^[a-z][a-zA-Z0-9]*$/', $key) === 1;
    }

    private function isValidContextValue(mixed $value): bool
    {
        if (is_scalar($value) || is_null($value)) {
            return true;
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if (! is_scalar($item) && ! is_null($item)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }
}
