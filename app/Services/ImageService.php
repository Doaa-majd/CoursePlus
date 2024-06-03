<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class ImageService
{
    public function uploadImage64ToDisk(string $image64, string $disk, string $folder): string
    {
        $image = preg_replace('#^data:image/\w+;base64,#i', '', $image64);
        $image = str_replace(' ', '+', $image);
        $imageName = ((string) \Str::uuid()) . '.' . explode('/', explode(':', substr($image64, 0, strpos($image64, ';')))[1])[1];
        \Storage::disk($disk)->put($folder . '/' . $imageName, base64_decode($image));
        return $folder . '/' . $imageName;
    }

    public function deleteImageFromDisk(string $disk, string|null $imagePath): void
    {
        $image = public_path($disk . '/') . $imagePath;
        if (file_exists($image)) {
            @unlink($image);
        }
    }
}
