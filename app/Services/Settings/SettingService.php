<?php

declare(strict_types=1);

namespace App\Services\Settings;

use App\Models\Setting;

class SettingService
{

    public function getGeneralSettings()
    {
        return Setting::where('prefix', 'general')->get();
    }

    public function getHomeSettings()
    {
        return Setting::where('prefix', 'regexp', '^home')->get();
    }

    public function getAboutSettings()
    {
        return Setting::where('prefix', 'regexp', '^about')->get();
    }

    public function updateGeneralSettings($data)
    {
        if (isset($data['image'])) {
            $storeAs = 'settings';
            $imageName = 'logo.' . $data['image']->extension();
            $path = $data['image']->storeAs($storeAs, $imageName, 'images');
            $data['image'] = $path;


            $oldLogoImg = Setting::where('name', 'Site logo')->first()->value;
            $logo = public_path('images/') . $oldLogoImg;
            if (file_exists($logo)) {
                @unlink($logo);
            }
            ///// update values
            Setting::where('name', 'commission')->update([
                'value' => $data['commission'],
                ]);
            Setting::where('name', 'Site logo')->update([
                'value' => $data['image'],
                ]);
        } else {
            Setting::where('name', 'commission')->update([
                'value' => $data['commission'],
                ]);
        }
    }

    public function updateHomeSettings($data, $id)
    {
        Setting::where('id', $id)->update([
            'value' => $data['value'],
            ]);
    }
}
