<?php

namespace Gawsoft\LaravelSecrets\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

trait ConfigsMapTrait {

    static function prepareConfigMapsToRedacted(): Collection {
        $whitelist = Config::get('secrets.logs.whitelist');
        $configs = Config::all();

        if (count($whitelist) == 0)
            $configMaps = self::generateTreeConfigMaps($configs);
        else
            $configMaps = self::prepareWhitelistToRedacted($configs, $whitelist);

        self::prepareBlacklistToRedacted($configMaps, Config::get('secrets.logs.blacklist'));
        return $configMaps;
    }

    static function generateTreeConfigMaps(&$configData): Collection
    {
        return collect(Arr::dot($configData));
    }

    static function prepareWhitelistToRedacted(array &$data, array &$whitelist): Collection
    {
        $data = Arr::dot($data);
        $selected_configs = [];

        foreach($data as $key=>$value)
        {
            foreach($whitelist as $whitelist_value){
                if (Str::startsWith($key, $whitelist_value))
                    $selected_configs[$key] = $value;
            }
        }

        return collect($selected_configs);
    }


    static function prepareBlacklistToRedacted(Collection &$data, array $blacklist): void
    {
        if (count($blacklist) == 0) return;
        $data = $data->filter(function($item, $key) use($blacklist) {
            foreach($blacklist as $blacklist_item){
                if (Str::startsWith($key, $blacklist_item)) return false;
            }
            return true;
        });
    }
}