<?php

namespace Gawsoft\LaravelSecrets\Tests;

use Gawsoft\LaravelSecrets\LaravelSecretsServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase {

    function setUp(): void
    {
        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {
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