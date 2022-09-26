<?php

namespace Gawsoft\LaravelSecrets\Secrets;

use Gawsoft\LaravelSecrets\Interfaces\SecretProviderInterface;
use Illuminate\Support\Facades\Config;

class Secrets
{
    private SecretProviderInterface $strategy;

    function autoloadStrategy($cls = null)
    {
        $strategyConfig = $this->getStrategyFromConfig();
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

    protected function getStrategyFromConfig()
    {
        return Config::get('secrets.strategy');
    }
}