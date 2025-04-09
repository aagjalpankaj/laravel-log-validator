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

```
'single' => [
    'driver' => 'single',
    'tap' => [Aagjalpankaj\LaravelLogValidator\Logger::class],
    // other existing configuration...
],
```

Otherwise, create new one monolog channel, e.g:
```bash
'single' => [
    'driver' => 'single',
    'tap' => [Aagjalpankaj\LaravelLogValidator\Logger::class],
    'path' => storage_path('logs/laravel.log'),
    'level' => env('LOG_LEVEL', 'debug'),
    'replace_placeholders' => true,
],
```

Change logging driver in `.env` accordingly:
```bash
LOG_CHANNEL=single
```
