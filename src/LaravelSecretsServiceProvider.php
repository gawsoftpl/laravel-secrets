<?php

namespace Gawsoft\LaravelSecrets;

use Gawsoft\LaravelSecrets\Commands\DecryptSecret;
use Gawsoft\LaravelSecrets\Commands\EncryptSecret;
use Gawsoft\LaravelSecrets\Handlers\LogsSecretsRemoverHandler;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class LaravelSecretsServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/secrets.php','secrets');
    }

    public function boot(

    ){

        $default_logging = Config::get('logging.default');
        $this->app->make('config')->set('logging.channels.'.$default_logging.'.tap', [
            LogsSecretsRemoverHandler::class
        ]);

        $this->publishes([
            __DIR__ . '/Config/secrets.php' => config_path('secrets.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                EncryptSecret::class,
                DecryptSecret::class,
            ]);
        }


        if (!$this->app->configurationIsCached()) {

        }

    }
}