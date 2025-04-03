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
'llv' => [
  'driver' => 'llv',
  'via' => Aagjalpankaj\LaravelLogValidator\Logger::class,
]
```

Update logging driver in `.env`:
```bash
LOG_CHANNEL=llv
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

```
{
  "timestamp": "2025-04-03T12:34:56.789Z",
  "level": "error",
  "message": "User authentication failed",
  "context": {
    "user_id": 12345,
    "ip_address": "192.168.1.1"
  },
  "metadata": {
    "transaction_id": "abc-123-xyz",
    "service": "auth-service",
    "env": "production"
  }
}
```

```
{
  "timestamp": "2025-04-03T14:20:15.456Z",
  "level": "error",
  "message": "SQLSTATE[HY000]: General error: 1364 Field 'email' doesn't have a default value",
  "exception": {
    "class": "Illuminate\\Database\\QueryException",
    "file": "/var/www/html/app/Models/User.php",
    "line": 45,
    "trace": [
      "Illuminate\\Database\\Connection:runQueryCallback (vendor/laravel/framework/src/Illuminate/Database/Connection.php:695)",
      "Illuminate\\Database\\QueryException:__construct (vendor/laravel/framework/src/Illuminate/Database/QueryException.php:42)"
    ]
  },
  "context": {
    "request_id": "abc-123",
    "user_id": 12,
    "ip": "192.168.1.10",
    "url": "https://example.com/register"
  }
}
```
