<?php

declare(strict_types=1);

namespace Tests;

use Aagjalpankaj\LaravelLogValidator\Logger;
use Illuminate\Contracts\Config\Repository;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Orchestra\Testbench\TestCase;

abstract class FeatureTestCase extends TestCase
{
    protected function defineEnvironment($app): void
    {
        tap($app['config'], function (Repository $config) {
            $config->set('logging.channels.custom', [
                'driver' => 'custom',
                'via' => Logger::class,
                'level' => env('LOG_LEVEL', 'debug'),
                'handler' => StreamHandler::class,
                'with' => [
                    storage_path('logs/laravel.log'),
                    'debug',
                ],
                'formatter' => env('LOG_STDERR_FORMATTER'),
                'processors' => [PsrLogMessageProcessor::class],
            ]);

            $config->set('logging.default', 'custom');
        });
    }

    protected function defineRoutes($router): void
    {
        $router->get('/', function () {
            return response()->json(['message' => 'Welcome to Laravel Log Validator']);
        })->name('home');
    }
}
