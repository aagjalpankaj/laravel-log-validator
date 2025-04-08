# Laravel Log Validator

**Laravel Log Validator** validates logs at runtime in non-production environments, helping to make logging more concise and consistent across your application.

It not only validates logs but also adds additional application metadata, making log aggregation, searching, and analysis more efficient.

It is built on top of [Monolog](https://github.com/Seldaek/monolog), so you stream logs wherever you want.

## Installation

Install the package:
```bash
composer require aagjalpankaj/laravel-log-validator
```

Create custom channel in `logging.php`:
```bash
'custom' => [
    'driver' => 'custom',
    'via' => Aagjalpankaj\LaravelLogValidator\Logger::class,
    'level' => env('LOG_LEVEL', 'debug'),
    'handler' => StreamHandler::class,
    'formatter' => env('LOG_STDERR_FORMATTER'),
    'with' => [
        storage_path('logs/laravel.log'),
        'debug',
    ],
    'processors' => [PsrLogMessageProcessor::class],
],
```

Update logging driver in `.env`:
```bash
LOG_CHANNEL=custom
```

## Features
- Validates log message including context and throws `UnprocessableLogException` — configurable, default for non-prod environments.
- Adds application meta (application name & environment) that log aggregation, searching, and analysis more efficient.
- `artisan log:insights` gives you quick insights about logging in your application.
