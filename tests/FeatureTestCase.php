<?php

declare(strict_types=1);

namespace Tests;

use Aagjalpankaj\LaravelLogValidator\Logger;
use Illuminate\Contracts\Config\Repository;
use Orchestra\Testbench\TestCase;

abstract class FeatureTestCase extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['env'] = 'local';

        tap($app['config'], function (Repository $config) {

            $config->set('logging.channels.single', [
                'driver' => 'single',
                'tap' => [Logger::class],
                'path' => storage_path('logs/laravel.log'),
                'level' => env('LOG_LEVEL', 'debug'),
                'replace_placeholders' => true,
            ]);

            $config->set('logging.default', 'single');
        });
    }

    protected function defineRoutes($router): void
    {
        $router->get('/', function () {
            return response()->json(['message' => 'Welcome to Laravel Log Validator']);
        })->name('home');
    }
}
