<?php

namespace Gawsoft\LaravelSecrets\Actions;

use Gawsoft\LaravelSecrets\Traits\ConfigsMapTrait;
use Illuminate\Support\Collection;

class LogsCleaner {

    use ConfigsMapTrait;

    private ?Collection $configsMap = null;

    function removeSecretsFromString(string &$log): void {
        $this->configsMap = self::prepareConfigMapsToRedacted();
        $this->configsMap->each(function($config_value) use(&$log) {
            $log = str_replace( $config_value, "[redacted]", $log);
        });
        $this->clearConfigsMap();
    }

    function clearConfigsMap()
    {
        $this->clearMemory();
    }

    static function convertArrayToString(array $data): string {
        return json_encode($data);
    }

    static function convertStringtoArray(string $data): array {
        return json_decode($data,1);
    }

    protected function clearMemory()
    {
        $this->configsMap = null;
        unset($this->configsMap);
    }
}