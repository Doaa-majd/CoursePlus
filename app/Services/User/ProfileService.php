<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileService
{

    public function getUserProfile(): User
    {
        $userId = Auth::id();
        $userWithProfile = User::with('profile')
            ->findOrFail($userId);
        return $userWithProfile;
    }
}
