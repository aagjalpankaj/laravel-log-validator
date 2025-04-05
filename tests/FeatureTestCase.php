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
        tap($app['config'], function (Repository $config) {
            $config->set('logging.channels.custom', [
                'driver' => 'custom',
                'via' => Logger::class,
            ]);

            $config->set('logging.default', 'custom');
        });
    }

    protected function defineRoutes($router): void
    {
        $router->get('/', function () {
            return response()->json(['message' => 'Welcome to Laravel Log Validator']);
        })->name('home');

        $router->get('/log-test', function () {
            logger()->info('Test log message', ['context' => 'testing']);

            return response()->json(['status' => 'logged']);
        })->name('log.test');
    }
}
