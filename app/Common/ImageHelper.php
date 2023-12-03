<?php

namespace App\Common;

use App\Enum\SystemSettingKeyEnum;
use App\Exceptions\BusinessLogicException;
use App\Models\SystemSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Container\BindingResolutionException;
use Intervention\Image\Facades\Image as ImageIntervention;
use Illuminate\Support\Str;

class ImageHelper
{
    public $disk;
    public $configKey = 'default';

    public $hasOptimization = false;

    protected $validExtension = [
        'png',
        'jpg',
        'jpeg',
    ];

    public function __construct($disk)
    {
        $this->disk  = Storage::disk($disk);
    }

    /**
     * @return static
     * @return BindingResolutionException
     */
    public static function make($disk)
    {
        return app(static::class, ['disk' => $disk]);
    }

    public function setConfigKey($configKey)
    {
        $this->configKey = $configKey;

        return $this;
    }

    public function hasOptimization($bool = true)
    {
        $this->hasOptimization = $bool;

        return $this;
    }

    public function uploadImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            if ($this->hasOptimization) {
                return $this->saveByImageIntervention(data_get($image, 'file'));
            }
        }

        return null;
    }

    public function saveByImageIntervention(UploadedFile $image)
    {
        $filename   = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
        $config     = $this->getConfig();
        $cfWidth   = data_get($config, 'width');
        $cfHeight  = data_get($config, 'height');
        $cfRatio   = data_get($config, 'ratio');
        $cfExt     = data_get($config, 'ext');
        $cfFolder  = data_get($config, 'folder', '');

        if (! in_array($cfExt, $this->validExtension)) {
            throw new BusinessLogicException('Invalid config image extension: '.$cfExt.'. Just supported: '.implode(', ', $this->validExtension).'. Please check system setting config.');
        }

        $imageIntervention = ImageIntervention::make($image);
        $imageIntervention = $imageIntervention->encode($cfExt);
        // $imageIntervention = $imageIntervention->resize($cfWidth, $cfHeight, function($constraint) use ($cfRatio) {
        //     $constraint->aspectRatio();
        // });

        $imageIntervention->fit($cfWidth, $cfHeight, function($constraint) use ($cfRatio) {
            $constraint->aspectRatio();
        });

        $now = now();

        $dateNow = $now->format('d-m-Y');

        $pathname = implode('/', [$dateNow, $cfFolder, "{$filename}.{$cfExt}"]);

        $filename = $this->disk->put($pathname, $imageIntervention->stream()->__toString());

        return $this->disk->url($pathname);
    }

    public function getConfig()
    {
        $imageConfiguration = SystemSetting::from(SystemSettingKeyEnum::IMAGE_CONFIGURATION)->get(null, []);

        $config = data_get($imageConfiguration, $this->configKey);

        return $config;
    }
}
