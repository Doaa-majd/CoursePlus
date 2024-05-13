<?php

namespace App\Http\Controllers\Web\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Settings\SettingService;
use App\Http\Requests\Web\Settings\HomeSettingUpdateRequest;

class HomeSettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getHomeSettings();
        return view('admin.setting.home', [
        'settings' => $settings,
        ]);
    }

    public function update(HomeSettingUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $this->settingService->updateHomeSettings($data, $id);
        return response()->json(['success' => "Setting Updated successfully."]);
    }
}
