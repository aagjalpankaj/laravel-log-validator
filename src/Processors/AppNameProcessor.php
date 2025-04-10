<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Processors;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class AppNameProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['app_name'] = config('app.name');

        return $record;
    }
}
