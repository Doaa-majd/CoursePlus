<?php

declare(strict_types=1);

namespace App\Services\Profiles;

use App\Models\Profile;
use App\Services\ImageService;
use App\Models\User;

class ProfileService
{
    protected $imageService;
    private const IMAGE = 'image';
    private const COVER_IMAGE = 'cover_image';

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

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

    public function getInstructorProfile($userId)
    {
        $user = User::where('id', $userId)->with('profile')->get();
        return \Arr::first($user)->profile;
    }

    public function update($data)
    {
        if (isset($data['image'])) {
            $imagePath = $this->imageService->uploadImage64ToDisk($data['image'], 'images', 'users');
            $this->imageService->deleteImageFromDisk('images', \Auth::user()->profile->image);
            \Auth::user()->profile()->update(['image' => $imagePath]);
            return;
        }
        if (isset($data['cover_image'])) {
            $imagePath = $this->imageService->uploadImage64ToDisk($data['cover_image'], 'images', 'users');
            $this->imageService->deleteImageFromDisk('images', \Auth::user()->profile->cover_image);
            \Auth::user()->profile()->update(['cover_image' => $imagePath]);
            return;
        }
        Profile::where('user_id', \Auth::id())->update($data);
    }

    // to delete the image or cover image
    public function delete($data)
    {
        if ($data['image_type'] == self::IMAGE) {
            $this->imageService->deleteImageFromDisk('images', \Auth::user()->profile->image);
            \Auth::user()->profile()->update(['image' => null]);
        }
        if ($data['image_type'] == self::COVER_IMAGE) {
            $this->imageService->deleteImageFromDisk('images', \Auth::user()->profile->cover_image);
            \Auth::user()->profile()->update(['cover_image' => null]);
        }
    }
}
