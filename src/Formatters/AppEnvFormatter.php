<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Formatters;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

final class AppEnvFormatter implements FormatterInterface
{
    public function format(LogRecord $record): LogRecord
    {
        if (isset($record->extra['environment'])) {
            $record->extra['environment'] = strtolower((string) $record->extra['environment']);
        }

        return $record;
    }

    public function formatBatch(array $records): array
    {
        foreach ($records as $key => $record) {
            $records[$key] = $this->format($record);
        }

        return $records;
    }
}
