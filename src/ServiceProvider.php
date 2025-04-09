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
        ], 'laravel-log-validator');

        $this->registerCommands();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-log-validator.php', 'laravel-log-validator'
        );
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\LogInsightsCommand::class,
            ]);
        }
    }
}
