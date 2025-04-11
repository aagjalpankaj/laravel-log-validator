<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Processors;

use Aagjalpankaj\Lalo\Dto\TraceId;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class TraceIdProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        if (App::runningInConsole()) {
            $traceId = TraceId::forCli()->value;
        } else {
            $traceId = Request::header('x-trace-id') ?? TraceId::forWeb()->value;
        }

        $record->extra['trace_id'] = $traceId;

        return $record;
    }
}
