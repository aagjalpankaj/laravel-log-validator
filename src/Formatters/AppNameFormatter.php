<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator\Formatters;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

final class AppNameFormatter implements FormatterInterface
{
    public function format(LogRecord $record): LogRecord
    {
        if (isset($record->extra['app_name'])) {
            $record->extra['app_name'] = $this->formatAppName($record->extra['app_name']);
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

    private function formatAppName(string $appName): string
    {
        return preg_replace(
            '/[^a-z0-9_]/',
            '',
            (string) preg_replace('/[\s-]+/', '_', strtolower($appName))
        );
    }
}
