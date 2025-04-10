<?php

declare(strict_types=1);

namespace Aagjalpankaj\LaravelLogValidator;

use Aagjalpankaj\LaravelLogValidator\Middleware\RequestIdMiddleware;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-log-validator.php' => config_path('laravel-log-validator.php'),
        ], 'config');

        $this->registerCommands();

        $this->app['router']->aliasMiddleware('request-id', RequestIdMiddleware::class);

        $this->app['router']->middlewareGroup('web', [RequestIdMiddleware::class]);
        $this->app['router']->middlewareGroup('api', [RequestIdMiddleware::class]);
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
