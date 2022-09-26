<?php

namespace Gawsoft\LaravelSecrets\Secrets;

use Gawsoft\LaravelSecrets\Interfaces\SecretProviderInterface;
use Illuminate\Config\Repository;

class Secrets
{
    private SecretProviderInterface $strategy;


    function setStrategy(SecretProviderInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    function secret(string $name)
    {
        return $this->strategy->getSecret($name);
    }

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


    protected function getStrategyConfig()
    {
        return $this->getConfig()['strategy'];
    }

    protected function getConfig()
    {
        $config = config()?->get('secrets');
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

        return require $path;
    }

}