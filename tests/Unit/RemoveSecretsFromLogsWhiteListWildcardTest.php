<?php


namespace Gawsoft\LaravelSecrets\Tests\Unit;

use Gawsoft\LaravelSecrets\Tests\TestCase;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class RemoveSecretsFromLogsWhiteListWildcardTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
        Config::set('secrets.logs.whitelist', [
            'mail.mailers.smtp'
        ]);
        Config::set('database.connections.mysql', 'SECRET_MYSQL_PASSWORD');
        Config::set('mail.mailers.smtp.password', 'SECRET_SMTP_PASSWORD');
    }

    function test_remove_secrets_from_logs()
    {
        $redaction = Config::get('secrets.strategy.redaction');
        Log::error('Cant connect with database password SECRET_MYSQL_PASSWORD');
        Log::error('Cant connect with mail SECRET_SMTP_PASSWORD');
        $logger = Log::getLogger();
        $this->assertEquals('Cant connect with database password SECRET_MYSQL_PASSWORD',$logger->getHandlers()[0]->getLogs()[0]['message']);
        $this->assertEquals('Cant connect with mail '.$redaction, $logger->getHandlers()[0]->getLogs()[1]['message']);
    }

}