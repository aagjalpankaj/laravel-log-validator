<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Processors;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class RequestIdProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        if (App::runningInConsole()) {
            $requestId = uniqid('cli-', true);
        } else {
            $requestId = Request::header('x-request-id') ?? uniqid('req-', true);
        }

        $record->extra['request_id'] = $requestId;

        return $record;
    }
}
