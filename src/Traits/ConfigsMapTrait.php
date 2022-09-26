<?php

namespace Gawsoft\LaravelSecrets\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

trait ConfigsMapTrait {

    static function prepareConfigMapsToRedacted(): Collection {
        $data = [];
        self::generateTreeConfigMaps(Config::all(), $data);
        $configMaps = collect($data);
        self::prepareWhitelistToRedacted($configMaps, collect(Config::get('secrets.logs.whitelist')));
        self::prepareBlacklistToRedacted($configMaps, collect(Config::get('secrets.logs.blacklist')));
        return $configMaps;
    }

    static function generateTreeConfigMaps($configData, &$map = [], $parent_key = "")
    {
        collect($configData)->each(function($value, $key) use(&$map, &$parent_key){
            if (is_array($value)) self::generateTreeConfigMaps($value, $map, $parent_key.$key.".");
            else $map["{$parent_key}{$key}"] = $value;
        });
    }

    static function prepareWhitelistToRedacted(Collection &$data, Collection $whitelist): void
    {
        if ($whitelist->count() == 0) return;
        $data = $data->filter(fn($item, $key) => $whitelist->contains($key));
    }

    static function prepareBlacklistToRedacted(Collection &$data, Collection $blacklist): void
    {
        if ($blacklist->count() == 0) return;
        $data = $data->filter(fn($item, $key) => !$blacklist->contains($key));
    }
}