<?php

namespace App\Common;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Container\BindingResolutionException;

class ImageHelper
{
    public $disk;

    public function __construct($disk)
    {
        $this->disk = Storage::disk($disk);
    }

    /**
     * @return static
     * @return BindingResolutionException
     */
    public static function make($disk)
    {
        return app(static::class, ['disk' => $disk]);
    }

    public function uploadImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            $imageFile = data_get($image, 'file');
            $filename  = $this->disk->put('/', $imageFile);
            $imageUrl = $this->disk->url($filename);

            return $imageUrl;
        }

        return null;
    }
}
