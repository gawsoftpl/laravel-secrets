<?php

namespace Gawsoft\LaravelSecrets\Tests\Unit;

use Gawsoft\LaravelSecrets\Tests\TestCase;
use Illuminate\Support\Facades\Config;

class HelpersTest extends TestCase {

    function setUp(): void
    {
        parent::setUp();
        Config::set('secrets.strategy.config.path', __DIR__.'/../secrets/');
    }

    function test_helpers_laravel_secrets_full_path(){
        $this->assertEquals('test-db-password', laravel_secrets(__DIR__.'/../secrets/db/password'));
    }

    function test_helpers_laravel_secrets(){
        $this->assertEquals('test-db-password', laravel_secrets('db/password'));
    }

    function test_ahelpers_laravel_secrets_encrypted(){
        $this->assertEquals('abc', laravel_secrets('db/encrypted-password'));
    }

    function test_helpers_laravel_secrets_file_not_exists(){
        $this->assertEquals(null, laravel_secrets('db/passworddsff34'));
    }

    function test_helpers_laravel_secrets_file_not_exists_usage_default_value(){
        $this->assertEquals('abc', laravel_secrets('db/passworddsff34','abc'));
    }
}

