<?php

namespace Gawsoft\LaravelSecrets\Abstracts;

use Gawsoft\LaravelSecrets\Interfaces\SecretProviderInterface;

abstract class SecretsProviderAbstract implements SecretProviderInterface {
    protected array $config;

    public function setConfig(array $config): void {
        $this->config = $config;
    }
}