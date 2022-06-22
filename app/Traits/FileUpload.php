<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Handle file uploads
 */
trait FileUpload
{
    /**
     * upload given file.
     *
     * @param  UploadedFile  $file
     * @return false|string
     */
    public function upload(UploadedFile $file)
    {
        return Storage::putFileAs('products', $file, $file->getClientOriginalName());
    }
}