<?php

namespace Gawsoft\LaravelSecrets\Actions;

use Illuminate\Support\Facades\Crypt;

class EncryptSecret
{
    static function handle(string $data): string
    {
        return (Config('secrets.strategy.config.encrypted_prefix') ?? '').Crypt::encrypt($data);
    }
}