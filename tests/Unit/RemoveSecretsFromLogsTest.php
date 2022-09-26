<?php


namespace Gawsoft\LaravelSecrets\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class RemoveSecretsFromLogsTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
        Config::set('database.connections.mysql.password', 'SECRET_MYSQL_PASSWORD');
        Config::set('mail.mailers.smtp.password', 'SECRET_SMTP_PASSWORD');
    }

    function test_remove_secrets_from_logs()
    {
        Log::error('Cant connect with database password SECRET_MYSQL_PASSWORD');
        $logger = Log::getLogger();
        $this->assertEquals('Cant connect with [redacted] password [redacted]',$logger->getHandlers()[0]->getLogs()[0]['message']);
    }

    function test_remove_secrets_smtp_from_logs()
    {
        Log::error('Cant connect with mail SECRET_SMTP_PASSWORD');
        $logger = Log::getLogger();
        $this->assertEquals('Cant connect with mail [redacted]',$logger->getHandlers()[0]->getLogs()[0]['message']);
    }
}