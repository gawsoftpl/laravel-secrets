<?php

namespace Gawsoft\LaravelSecrets\Commands;

use Illuminate\Console\Command;
use Gawsoft\LaravelSecrets\Actions\EncryptSecret as EncryptSecretAction;

class EncryptSecret extends Command
{
    protected $signature = 'laravel-secret:encrypt {secret}';
    protected $description = 'Encrypt string with Laravel crypto method';

    function handle()
    {
        $this->info(EncryptSecretAction::handle($this->argument('secret')));
        return 0;
    }
}