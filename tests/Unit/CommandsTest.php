<?php

namespace Gawsoft\LaravelSecrets\Tests\Unit;

use Symfony\Component\Console\Exception\RuntimeException;
use Gawsoft\LaravelSecrets\Tests\TestCase;

class CommandsTest extends TestCase {

    function test_command_encrypt(){
        $this->artisan('laravel-secrets:encrypt abc')
            ->assertExitCode(0);
    }

    function test_command_encrypt_no_set_value(){
        $this->artisan('laravel-secrets:encrypt ')
            ->assertFailed();
    }

    function test_command_decrypt(){
        $this->artisan('laravel-secrets:decrypt encrypted:eyJpdiI6InhQbEhUREJQa21mcW85M0tYSEhhOUE9PSIsInZhbHVlIjoiY2pXZ0lqUlY4YVoydDdyZzVHak9XUT09IiwibWFjIjoiMWFlZjA4MGIyN2Q2YmEwMzc4ZGNjNTYzYTgyOTNiMzFiOWM0OTVmZWFkNGYzZTFiNDAwM2Y1NzgyYWJlMDEwMCIsInRhZyI6IiJ9')
            ->expectsOutput('abc')
            ->assertExitCode(0);
    }

    function test_command_decrypt_no_set_value(){
        $this->artisan('laravel-secrets:decrypt')
            ->assertFailed();
    }
}