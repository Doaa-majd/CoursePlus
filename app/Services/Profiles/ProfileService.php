<?php

declare(strict_types=1);

namespace App\Services\Profiles;

use App\Models\Profile;

class ProfileService
{

    public function updateProfile(array $data): void
    {
        if (isset($data['image'])) {
            $storeAs = 'profiles' . '/' . 'user-' . \Auth::id() ;
            $imageName = $data['fname'] . '.' . $data['image']->extension();
            $path = $data['image']->storeAs($storeAs, $imageName, 'images');
            $data['image'] = $path;

            Profile::updateOrCreate([
                'user_id' => \Auth::id(),
            ], [
                'image' => $data['image']
            ]);
        }

        Profile::updateOrCreate([
            'user_id' => \Auth::id(),
        ], [
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'address' => $data['address'],
            'country' => $data['country'],
            'bio' => $data['bio'],
            'interests' => $data['interests'],
            'level' => $data['level'],
            'locale' => $data['locale'],
        ]);
    }
}
