# Installation

### Install the package:
```bash
composer require aagjalpankaj/laravel-log-validator
```

### Publish the config:
```bash
php artisan vendor:publish
```

### Configure logging channel

If you're already using monolog channel, just configure below option

```
'tap' => [Logger::class]
```

Otherwise, create new one, e.g:
```bash
'single' => [
    'driver' => 'single',
    'tap' => [Logger::class],
    'path' => storage_path('logs/laravel.log'),
    'level' => env('LOG_LEVEL', 'debug'),
    'replace_placeholders' => true,
],
```

Update logging driver in `.env`:
```bash
LOG_CHANNEL=single
```
