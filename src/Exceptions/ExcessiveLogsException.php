<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Exceptions;

use Exception;

/**
 * @codeCoverageIgnore
 */
final class ExcessiveLogsException extends Exception
{
    public function __construct(string $message = 'Excessive logs detected')
    {
        parent::__construct($message, 429);
    }
}
