<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Web\Users\ProfileUpdateRequest;
use App\Models\Profile;
use App\Services\Profiles\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function create()
    {
        $profile = \Auth::user()->profile ;
        return view('users.profile', [
            'profile' => $profile,
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();
        $this->profileService->updateProfile($data);
        return redirect()->route('profiles.create')->with('alert.success', 'profile updated successfully');
    }
}
