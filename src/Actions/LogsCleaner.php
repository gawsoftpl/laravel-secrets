<?php

namespace Gawsoft\LaravelSecrets\Actions;

use Gawsoft\LaravelSecrets\Traits\ConfigsMapTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class LogsCleaner {

    use ConfigsMapTrait;

    private ?Collection $configsMap = null;

    function removeSecretsFromString(string &$log): void {
        $redaction = Config::get('secrets.strategy.redaction');
        $this->configsMap = self::prepareConfigMapsToRedacted();

        $this->configsMap->each(function($config_value) use(&$log, $redaction) {
            if (is_string($config_value)) $log = str_replace( $config_value, $redaction, $log);
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