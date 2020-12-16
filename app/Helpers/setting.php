<?php

use App\Enums\SettingKey;
use App\Models\Setting;


function settings() {
    if (!Schema::hasTable((new Setting)->getTable())) {
        return [];
    }

    $settings = [];
    $models = Setting::select('key', 'value')->pluck('value', 'key');

    foreach (SettingKey::getValues() as $key) {
        $settings[$key] = isset($models[$key]) ? $models[$key] : null;

        if (!$settings[$key]) {
            if ($key === SettingKey::SiteLogo) {
                $settings[$key] = asset('images/logo.png');
            } elseif ($key === SettingKey::SiteName) {
                $settings[$key] = config('app.name');
            }
        }
    }
    return $settings;
}

function translatableSettings() {
    return Setting::select('key', 'value')
            ->whereIn('key', SettingKey::translatableKeys())->get()->keyBy('key');
}
