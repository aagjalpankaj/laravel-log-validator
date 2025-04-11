<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Environment
    |--------------------------------------------------------------------------
    |
    | Specify which environments should have log validation enabled.
    | In production, you typically want to disable validation for performance and also not recommended.
    |
    */
    'validate_only_on' => ['local', 'testing', 'staging'],

    /*
    |--------------------------------------------------------------------------
    | Log Message Validation Rules
    |--------------------------------------------------------------------------
    |
    | Configure the validation rules for log messages.
    |
    */
    'log_message' => [
        'max_length' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Context Validation Rules
    |--------------------------------------------------------------------------
    |
    | Configure the validation rules for log context arrays.
    |
    */
    'log_context' => [
        'max_fields' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Metadata
    |--------------------------------------------------------------------------
    |
    | Configure additional metadata to be added to each log entry.
    |
    */
    'log_meta' => [
        'include_app_name' => true,
        'include_app_env' => true,
        'include_trace_id' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Insights
    |--------------------------------------------------------------------------
    |
    | Configure directories to scan for log insights command.
    | These directories will be analyzed for logging patterns.
    |
    */
    'insights' => [
        'source_directories' => ['app'],
    ],
];
