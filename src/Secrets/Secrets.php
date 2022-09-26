<?php

namespace Gawsoft\LaravelSecrets\Secrets;

use Gawsoft\LaravelSecrets\Interfaces\SecretProviderInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Config\Repository;

class Secrets
{
    private SecretProviderInterface $strategy;

    function autoloadStrategy($cls = null)
    {
        $strategyConfig = $this->getStrategyConfig();

        if ($cls) {
            $handler = app($cls);
        } else {
            $handler = app($strategyConfig['handler']);
        }

        $handler->setConfig($strategyConfig['config']);
        $this->setStrategy($handler);
    }

    function setStrategy(SecretProviderInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    function secret(string $name)
    {
        return $this->strategy->getSecret($name);
    }

    protected function getStrategyConfig()
    {
        return $this->getConfig()->get('secrets.strategy');
    }

    protected function getConfig()
    {
        $config = config()->get('secrets');
        if ($config === null)
            return $this->parseConfig(config_path('secrets.php'));
        return $config;
    }

    protected function parseConfig(string $path)
    {
        if (!file_exists($path))
            throw new \Exception("Cant find config/secrets.php.
Please install vendor config. Run below command:
php artisan vendor:publish --provider=\"Gawsoft\LaravelSecrets\LaravelSecretsServiceProvider\"
            ");

        return new Repository(['secrets' => require $path]);
    }

}