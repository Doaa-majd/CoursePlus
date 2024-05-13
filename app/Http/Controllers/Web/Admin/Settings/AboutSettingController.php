<?php

namespace App\Http\Controllers\Web\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Settings\SettingService;
use App\Http\Requests\Web\Settings\AboutSettingUpdateRequest;

class AboutSettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getAboutSettings();
        return view('admin.setting.about', [
            'settings' => $settings,
        ]);
    }

    public function update(AboutSettingUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $this->settingService->updateHomeSettings($data, $id);
        return response()->json(['success' => "Setting Updated successfully."]);
    }
}
