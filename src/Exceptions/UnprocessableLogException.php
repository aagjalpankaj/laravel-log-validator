<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Exceptions;

use Exception;

final class UnprocessableLogException extends Exception
{
    public function __construct(string $message = 'Log validation failed')
    {
        parent::__construct($message, 422);
    }
}
