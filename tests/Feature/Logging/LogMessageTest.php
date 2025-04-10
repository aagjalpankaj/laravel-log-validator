<?php

declare(strict_types=1);

use Aagjalpankaj\Lalo\Exceptions\UnprocessableLogException;
use Illuminate\Support\Facades\Log;

test('log message under 50 chars', function () {
    $shortMessage = 'This is a valid log message under 50 characters';
    expect(function () use ($shortMessage) {
        Log::info($shortMessage);
    })->not->toThrow(UnprocessableLogException::class);
});

test('log message above 50 chars', function () {
    $longMessage = 'This is an invalid log message because it exceeds the maximum allowed length of fifty characters and should trigger validation failure';
    expect(function () use ($longMessage) {
        Log::info($longMessage);
    })->toThrow(UnprocessableLogException::class);
});
