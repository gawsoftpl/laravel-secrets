<?php

if (!function_exists('laravel_secrets')){
    function laravel_secrets($secret, $default = null): string | null
    {
        $secrets = app(Gawsoft\LaravelSecrets\Secrets\Secrets::class);
        $secrets->autoloadStrategy();
        return $secrets->secret($secret) ?? $default;
    }
}