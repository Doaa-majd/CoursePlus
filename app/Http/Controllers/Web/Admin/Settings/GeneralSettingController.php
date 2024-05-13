<?php

namespace App\Http\Controllers\Web\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Settings\SettingService;
use App\Http\Requests\Web\Settings\GeneralSettingUpdateRequest;

class GeneralSettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getGeneralSettings();
        return view('admin.setting.general', [
            'settings' => $settings,
        ]);
    }

    public function update(GeneralSettingUpdateRequest $request)
    {
        $data = $request->validated();
        $this->settingService->updateGeneralSettings($data);
        return response()->json(['success' => "Setting Updated successfully."]);
    }
}
