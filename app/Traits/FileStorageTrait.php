<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


trait FileStorageTrait
{
    private function getStorePathFromFile(UploadedFile $uploadedFile, $storePath = "public"): string
    {
        $randomString = Str::random(5);

        $fileName = time() . $randomString . '.' . $uploadedFile->extension();
        $storePath = $uploadedFile->storeAs($storePath, $fileName);

        return $storePath;
    }
}
