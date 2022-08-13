<?php

namespace App\Http\Controllers\Api\User;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\ProfileService;
use App\Http\Resources\Api\ProfileResource;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $userProfile = $this->profileService->getUserProfile();
        return response()->json(
            new ProfileResource(
                $userProfile
            )
        );
    }

    public function validateId($id)
    {
        Validator::validate([
            'id' => $id
        ], [
            'id' => 'required|string|exists:users,id'
        ]);
    }
}
