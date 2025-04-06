<?php

declare(strict_types=1);

use Aagjalpankaj\LaravelLogValidator\Exceptions\UnprocessableLogException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

test('validates only if it is not exception', function () {
    // Ensure validation is active in the current environment
    Config::set('laravel-log-validator.validate_only_on', [app()->environment()]);

    // This should throw an exception due to long message
    $longMessage = 'This is an invalid log message because it exceeds the maximum allowed length of fifty characters and should trigger validation failure';
    expect(function () use ($longMessage) {
        Log::info($longMessage);
    })->toThrow(UnprocessableLogException::class);

    // This should NOT throw an exception despite long message because it contains an exception
    $exception = new Exception('Some exception occurred');
    expect(function () use ($longMessage, $exception) {
        Log::info($longMessage, ['exception' => $exception]);
    })->not->toThrow(UnprocessableLogException::class);
});
