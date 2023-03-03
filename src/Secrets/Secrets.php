<?php

namespace Gawsoft\LaravelSecrets\Secrets;

use Gawsoft\LaravelSecrets\Interfaces\SecretProviderInterface;
use Illuminate\Support\Facades\Log;

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
            $config = $this->parseConfig(config_path('secrets.php'));

        if ($config === null)
            $config = $this->parseConfig(realpath(__DIR__.'/../Config/secrets.php'));

        if ($config === null)
            throw new \Exception("Cant find config/secrets.php.
Please install vendor config. Run below command:
php artisan vendor:publish --provider=\"Gawsoft\LaravelSecrets\LaravelSecretsServiceProvider\"
            ");

        return $config;
    }

    protected function parseConfig(string $path): array | null
    {
        if (!file_exists($path)) return null;
        return require $path;
    }

}