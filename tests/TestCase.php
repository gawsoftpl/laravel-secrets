<?php

namespace Gawsoft\LaravelSecrets\Tests;

use Gawsoft\LaravelSecrets\LaravelSecretsServiceProvider;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase {

    function setUp(): void
    {
        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {
//        $app['config']->set('logging.channels.testing',[
//            'driver' => 'custom',
//            'via' => TestLoggerHandler::class,
//        ]);
        $app['config']->set('logging.default','testing');
        $app['config']->set('logging.channels.testing',[
            'driver' => 'monolog',
            'handler' => TestLoggerHandler::class,
        ]);

    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSecretsServiceProvider::class,
        ];
    }
}