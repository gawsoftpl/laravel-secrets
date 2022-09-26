<?php

namespace Gawsoft\LaravelSecrets\Interfaces;

interface SecretProviderInterface {

    /**
     * Main method got straetgy
     * example usage: laravel_secrets('MYSQL_PASSWORD');
     * laravel_secrets('/run/secrets/mysql/password');
     * @param string $name
     * @return mixed
     */
    function getSecret(string $name) : string | null;
    function setConfig(array $config): void;
}