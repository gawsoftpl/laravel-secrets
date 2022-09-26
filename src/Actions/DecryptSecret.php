<?php

namespace Gawsoft\LaravelSecrets\Actions;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DecryptSecret
{
    static function handle(string $data): string
    {
        return Crypt::decrypt(Str::replace(Config('secrets.strategy.config.encrypted_prefix') ?? '', '' , $data));
    }
}