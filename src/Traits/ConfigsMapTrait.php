<?php

namespace Gawsoft\LaravelSecrets\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

trait ConfigsMapTrait {

    static function prepareConfigMapsToRedacted(): Collection {
        $configMaps = self::generateTreeConfigMaps(Config::all());
        self::prepareWhitelistToRedacted($configMaps, collect(Config::get('secrets.logs.whitelist')));
        self::prepareBlacklistToRedacted($configMaps, collect(Config::get('secrets.logs.blacklist')));
        return $configMaps;
    }

    static function generateTreeConfigMaps($configData): Collection
    {
        return collect(Arr::dot($configData));
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