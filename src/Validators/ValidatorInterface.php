<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Validators;

use Monolog\LogRecord;

interface ValidatorInterface
{
    public function validate(LogRecord $record): bool;
}
