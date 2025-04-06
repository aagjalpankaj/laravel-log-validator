<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-log-validator.php' => config_path('laravel-log-validator.php'),
        ], 'laravel-log-validator-config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-log-validator.php', 'laravel-log-validator'
        );
    }
}
