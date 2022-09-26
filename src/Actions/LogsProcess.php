<?php

namespace Gawsoft\LaravelSecrets\Actions;

class LogsProcess {

    function __construct(
        private LogsCleaner $logsCleaner
    ){}

    function processRecord(array $logRecord): array | string {
        $logRecord['message'] = is_array($logRecord['message'])
            ? $this->processArray($logRecord['message'])
            : $this->processString($logRecord['message']);
        return $logRecord;
    }

    function processArray(array $logRecordMessage): array
    {
        $str = LogsCleaner::convertArrayToString($logRecordMessage);
        $this->logsCleaner->removeSecretsFromString($str);
        return LogsCleaner::convertStringtoArray($str);
    }

    function processString(string $logRecordMessage): string
    {
        $this->logsCleaner->removeSecretsFromString($logRecordMessage);
        return $logRecordMessage;
    }
}