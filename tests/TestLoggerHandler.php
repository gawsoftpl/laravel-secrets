<?php

namespace Gawsoft\LaravelSecrets\Tests;

use Monolog\Handler\AbstractProcessingHandler;

class TestLoggerHandler extends AbstractProcessingHandler
{
    protected array $logs = [];

    function getLogs(): array {
        return $this->logs;
    }

    protected function write(array $record): void
    {
        $this->logs[] = $record;
    }
}
