<?php

declare(strict_types=1);

use Aagjalpankaj\Lalo\Exceptions\UnprocessableLogException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

test('validates only on non-production environment', function () {
    // Test with local environment (should validate)
    Config::set('lalo.validate_only_on', ['local', 'testing', 'staging']);
    app()->detectEnvironment(function () {
        return 'local';
    });

    expect(function () {
        Log::info('This is a very long message that exceeds the maximum allowed length for log messages and should trigger validation failure');
    })->toThrow(UnprocessableLogException::class);

    // Test with production environment (should not validate)
    app()->detectEnvironment(function () {
        return 'production';
    });

    expect(function () {
        Log::info('This is a very long message that exceeds the maximum allowed length for log messages but should not trigger validation failure in production');
    })->not->toThrow(UnprocessableLogException::class);
});
