<?php

namespace Gawsoft\LaravelSecrets\Tests;

use Gawsoft\LaravelSecrets\Actions\LogsCleaner;

class LogsCleanerTest extends TestCase
{
    function test_convert_array_to_string()
    {
        $this->assertEquals('{"a":1,"test":2}', LogsCleaner::convertArrayToString(["a"=>1,"test"=>2]));
    }

    function test_convert_string_to_array()
    {
        $this->assertEquals(["a"=>1,"test"=>2], LogsCleaner::convertStringtoArray('{"a":1,"test":2}'));
    }
}