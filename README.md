# Laravel Log Validator
Laravel package that validates logs runtime and ensures consistency in logging all across your application.
It helps maintain consistent logging patterns across your entire application ecosystem, making log aggregation, searching, and analysis more efficient.

## Features

- **Message Validation**: Ensures log messages follow consistent patterns and length constraints
- **Structured Logging**: Enforces structured log formats for better searchability
- **Error Handling**: Provides clear exceptions when logs don't meet validation criteria
- **Extensible Architecture**: Easily add custom validators and processors

## Installation

Install the package:
```bash
composer require aagjalpankaj/laravel-log-validator
```

Create custom channel in `logging.php`:
```bash
'custom' => [
    'driver' => 'monolog',
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

### TODO

- [ ] Formatter: Log is in JSON format.
- [ ] Processor: Transaction ID is added and passed to every incoming & outgoing request and log message.
- [ ] Processor: Log meta: environment, component, level, etc. is validated and added.
- [ ] Validator: Environment is added with correct naming convention.
- [ ] Processor: Log context is added under the `context` key.
- [ ] Validator: Validates log context: naming convention & type of each key-value.
- [ ] Validator: Validates log message format.
- [ ] Validator: When environment is not production and log doesn't comply with above requirements, throws `UnprocessableLogException`.
