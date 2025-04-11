# Installation

### Install the package
```bash
composer require aagjalpankaj/lalo
```

### Publish the config
```bash
php artisan vendor:publish --provider="Aagjalpankaj\Lalo\ServiceProvider"
```

### Configure logging channel

Add `tap` option to the monolog logging channel as below:

```php
'single' => [
    'driver' => 'single',
    'tap' => [Aagjalpankaj\Lalo\Logger::class],
    // other existing configuration...
],
```

Use the logging channel in `.env`:
```bash
LOG_CHANNEL=single
```

---
Optionally, you can configure options as per your preferences in the [config file](../config/lalo.php).
