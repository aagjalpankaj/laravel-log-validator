<?php

namespace Aagjalpankaj\LaravelLogValidator\Exceptions;

use Exception;

final class UnprocessableLogException extends Exception
{
    public function __construct(string $message = 'Log validation failed')
    {
        parent::__construct($message, 422);
    }
}
