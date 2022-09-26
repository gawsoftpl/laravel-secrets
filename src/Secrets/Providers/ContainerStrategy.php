<?php

namespace Gawsoft\LaravelSecrets\Secrets\Providers;

use Gawsoft\LaravelSecrets\Abstracts\SecretsProviderAbstract;
use Gawsoft\LaravelSecrets\Actions\DecryptSecret;
use Gawsoft\LaravelSecrets\Interfaces\SecretProviderInterface;
use Illuminate\Support\Str;

class ContainerStrategy extends SecretsProviderAbstract implements SecretProviderInterface
{
    function getSecret(string $name): string | null
    {
        if (!$this->exists($name)) return null;
        $str = $this->readFromFile($name);

        if (Str::startsWith($str,$this->config['encrypted_prefix'])) return $this->decryptString($str);
        return $str;
    }

    private function buildPath(string $name): string
    {
        if (Str::startsWith($name,'/')) return realpath($name);
        return realpath($this->config['path'].$name);
    }

    private function exists(string $name): bool
    {
        return file_exists($this->buildPath($name));
    }

    private function readFromFile(string $name): string
    {
        return file_get_contents($this->buildPath($name));
    }

    function decryptString($encrypted_secret): string
    {
        return DecryptSecret::handle($encrypted_secret);
    }

}