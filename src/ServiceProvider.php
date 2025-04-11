<?php

declare(strict_types=1);

namespace Aagjalpankaj\Lalo;

use Aagjalpankaj\Lalo\Middleware\TraceIdMiddleware;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/lalo.php' => config_path('lalo.php'),
        ], 'config');

        $this->registerCommands();

        if (config('lalo.log_meta.include_trace_id', true)) {
            $this->app['router']->aliasMiddleware('trace-id', TraceIdMiddleware::class);

            $this->app['router']->middlewareGroup('web', [TraceIdMiddleware::class]);
            $this->app['router']->middlewareGroup('api', [TraceIdMiddleware::class]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/lalo.php', 'lalo'
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
