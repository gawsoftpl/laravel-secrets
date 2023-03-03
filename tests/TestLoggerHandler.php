<?php

namespace Gawsoft\LaravelSecrets\Tests;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class TestLoggerHandler extends AbstractProcessingHandler
{
    protected array $logs = [];

    function getLogs(): array {
        return $this->logs;
    }

    protected function write(LogRecord $record): void
    {
        $this->logs[] = $record;
    }
}
