<?php

namespace Gawsoft\LaravelSecrets\Commands;

use Illuminate\Console\Command;
use Gawsoft\LaravelSecrets\Actions\DecryptSecret as DecryptSecretAction;

class DecryptSecret extends Command
{
    protected $signature = 'laravel-secret:decrypt {encrypted}';
    protected $description = 'Decrypt string with Laravel crypto method';

    function handle()
    {
        $this->info(DecryptSecretAction::handle($this->argument('encrypted')));
        return 0;
    }
}