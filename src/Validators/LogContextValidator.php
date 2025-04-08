<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Validators;

use Aagjalpankaj\LaravelLogValidator\Exceptions\UnprocessableLogException;
use Monolog\LogRecord;

final class LogContextValidator implements ValidatorInterface
{
    private int $maxFields = 10;

    public function validate(LogRecord $record): bool
    {
        $context = $record->context;

        if (count($context) > $this->maxFields) {
            throw new UnprocessableLogException('Log context cannot have more than 10 fields');
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
