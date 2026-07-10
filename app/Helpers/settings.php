<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $settings = Cache::rememberForever('global_settings', function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }
}
