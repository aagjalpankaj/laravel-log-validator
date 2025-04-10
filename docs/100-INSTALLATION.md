# Installation

### Install the package:
```bash
composer require aagjalpankaj/laravel-log-validator
```

### Publish the config:
```bash
php artisan vendor:publish --provider="Aagjalpankaj\LaravelLogValidator\ServiceProvider"
```

### Configure logging channel

If you're already using monolog channel, just configure `tap` option as below:

```php
'single' => [
    'driver' => 'single',
    'tap' => [Aagjalpankaj\LaravelLogValidator\Logger::class],
    // other existing configuration...
],
```

Otherwise, create a new monolog channel with `tap` option, e.g:
```php
'single' => [
    'driver' => 'single',
    'tap' => [Aagjalpankaj\LaravelLogValidator\Logger::class],
    'path' => storage_path('logs/laravel.log'),
    'level' => env('LOG_LEVEL', 'debug'),
    'replace_placeholders' => true,
],
```

Update logging channel in `.env` accordingly:
```bash
LOG_CHANNEL=single
```
---
Optionally, you can configure options as per your preferences in the [config file](../config/laravel-log-validator.php).