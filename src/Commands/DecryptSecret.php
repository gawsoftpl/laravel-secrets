<?php

namespace Gawsoft\LaravelSecrets\Commands;

use Illuminate\Console\Command;
use Gawsoft\LaravelSecrets\Actions\DecryptSecret as DecryptSecretAction;

class DecryptSecret extends Command
{
    protected $signature = 'laravel-secrets:decrypt {encrypted?} {--stdin}';
    protected $description = 'Decrypt string with Laravel crypto method';

    function handle()
    {
        $encrypted = $this->argument('encrypted');
        if (!$encrypted && $this->option('stdin')) {
            $encrypted = file_get_contents("php://stdin");
        }

        if (!$encrypted) {
            $this->error('No set data to decrypt');
            return 1;
        }

        $this->info(DecryptSecretAction::handle($encrypted));
        return 0;
    }
}