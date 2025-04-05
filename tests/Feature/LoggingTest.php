<?php

use Aagjalpankaj\LaravelLogValidator\Exceptions\UnprocessableLogException;
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

test('log context has less than 10 context fields', function () {
    $validContext = [
        'field1' => 'value1',
        'field2' => 'value2',
        'field3' => 'value3',
        'field4' => 'value4',
        'field5' => 'value5',
        'field6' => 'value6',
        'field7' => 'value7',
        'field8' => 'value8',
        'field9' => 'value9',
    ];

    expect(function () use ($validContext) {
        Log::info('Valid context test', $validContext);
    })->not->toThrow(UnprocessableLogException::class);
});

test('log context has more than 10 context fields', function () {
    $invalidContext = [
        'field1' => 'value1',
        'field2' => 'value2',
        'field3' => 'value3',
        'field4' => 'value4',
        'field5' => 'value5',
        'field6' => 'value6',
        'field7' => 'value7',
        'field8' => 'value8',
        'field9' => 'value9',
        'field10' => 'value10',
        'field11' => 'value11', // This exceeds the limit
    ];

    expect(function () use ($invalidContext) {
        Log::info('Invalid context test', $invalidContext);
    })->toThrow(UnprocessableLogException::class);
});
