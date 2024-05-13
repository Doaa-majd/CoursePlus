<?php

namespace App\Http\Controllers\Web\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Settings\SettingService;

class HomeSliderController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function update()
    {

    }
}
