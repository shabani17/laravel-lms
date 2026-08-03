<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadImage(
        UploadedFile $file,
        string $directory
    ): string {
        return $file->store($directory, 'public');
    }

    public function uploadVideo(
        UploadedFile $file,
        string $directory
    ): string {
        return $file->store($directory, 'public');
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}