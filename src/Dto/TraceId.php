<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo\Dto;

readonly class TraceId
{
    private function __construct(public string $value) {}

    public static function forCli(): TraceId
    {
        return new TraceId(uniqid('cli-', true));
    }

    public static function forWeb(): TraceId
    {
        return new TraceId(uniqid('web-', true));
    }
}
