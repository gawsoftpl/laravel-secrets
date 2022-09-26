<?php

namespace Gawsoft\LaravelSecrets\Interfaces;

interface SecretProviderInterface {
    function getSecret(string $name);
}