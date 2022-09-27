<?php

namespace Gawsoft\LaravelSecrets\Commands;

use Illuminate\Console\Command;
use Gawsoft\LaravelSecrets\Actions\EncryptSecret as EncryptSecretAction;

class EncryptSecret extends Command
{
    protected $signature = 'laravel-secrets:encrypt {secret?} {--stdin}';
    protected $description = 'Encrypt string with Laravel crypto method';

    function handle()
    {
        $secret = $this->argument('secret');
        if (!$secret && $this->option('stdin')) {
            $secret = trim(file_get_contents("php://stdin"));
        }

        if (!$secret) {
            $this->error('No set secret to encrypt');
            return 1;
        }

        $this->info(EncryptSecretAction::handle($secret));
        return 0;
    }
}