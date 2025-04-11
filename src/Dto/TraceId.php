<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Dto;

use Ramsey\Uuid\Uuid;

readonly class TraceId
{
    private function __construct(public string $value) {}

    public static function forCli(): TraceId
    {
        return new TraceId('cli-'.self::getUniqueId());
    }

    public static function forWeb(): TraceId
    {
        return new TraceId('web-'.self::getUniqueId());
    }

    private static function getUniqueId(): string
    {
        return Uuid::uuid4()->toString();
    }
}
