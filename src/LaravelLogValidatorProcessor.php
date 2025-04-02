<?php declare(strict_types=1);


namespace Monolog\Processor;

use Monolog\LogRecord;

class LaravelLogValidatorProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        return $record;
    }
}
