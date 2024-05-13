<?php

declare(strict_types=1);

namespace App\Services\Home;

use App\Models\Setting;

class HomeService
{

    public function getHomeSettings(): array
    {
        $settings = Setting::where('prefix', 'regexp', '^home')->get();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting->name] = $setting->value  ;
        }
        return $result;
    }
}
