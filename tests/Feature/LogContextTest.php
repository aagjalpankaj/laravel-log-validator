<?php

declare(strict_types=1);

use Aagjalpankaj\LaravelLogValidator\Exceptions\UnprocessableLogException;
use Illuminate\Support\Facades\Log;

test('log context has less than 10 fields', function () {
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

test('log context has more than 10 fields', function () {
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

test('log context has a field with no camelcase', function () {
    $invalidContext = [
        'order_id' => 'value1',
    ];

    expect(function () use ($invalidContext) {
        Log::info('Invalid context test', $invalidContext);
    })->toThrow(UnprocessableLogException::class);
});

test('log context accepts scalar values and arrays of scalars', function (string $key, $value) {
    $context = [$key => $value];

    expect(function () use ($context) {
        Log::info('Valid scalar context test', $context);
    })->not->toThrow(UnprocessableLogException::class);
})->with([
    ['intValue', 123],
    ['floatValue', 123.45],
    ['stringValue', 'test'],
    ['boolValue', true],
    ['nullValue', null],
    ['scalarArray', [1, 2.3, 'string', true, null]],
]);

test('log context rejects non-scalar values and nested arrays', function (string $key, $value) {
    $context = [$key => $value];

    expect(function () use ($context) {
        Log::info('Invalid scalar context test', $context);
    })->toThrow(UnprocessableLogException::class);
})->with([
    ['objectValue', new stdClass],
    ['nestedArrayValue', ['nested' => []]],
    ['resourceValue', fopen('php://memory', 'r')],
    ['closureValue', function () {
        return 'test';
    }],
    ['mixedArray', [1, new stdClass, 'string']],
]);
