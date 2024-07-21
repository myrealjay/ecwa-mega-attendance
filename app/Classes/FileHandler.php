<?php

namespace App\Classes;

use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class FileHandler
{
    public function upload(string $folderName,  string $newFileName, $file, string $storage = 'do') : string
    {
        $path = $storage === 'local' ? 'public/' : '';
        Storage::disk($storage)->put(
            "{$path}{$folderName}/{$newFileName}",
            file_get_contents($file)
        );

        $url = Storage::disk($storage)->url("{$folderName}/{$newFileName}");
        if ($storage === 'local') {
            $url = config('app.url').$url;
        }

        return $url;
    }

    public function getFileName() : string
    {
        $uuid4 = Uuid::uuid4();
        return $uuid4->toString();
    }
}