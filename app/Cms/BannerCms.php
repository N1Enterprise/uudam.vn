<?php

namespace App\Cms;

use App\Common\Cache;
use App\Enum\ActivationStatusEnum;
use App\Enum\BannerTypeEnum;
use App\Models\Banner;
use Illuminate\Contracts\Container\BindingResolutionException;

class BannerCms extends BaseCms
{
    public const CACHE_TAG = 'banner_cms';

    /**
     * @return Banner
     * @throws BindingResolutionException 
     */
    public function model()
    {
        return app(Banner::class);
    }

    public function homeBanners()
    {
        $cacheKey = 'home_banners';
        $now = now();

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() use ($now) {
            return $this->model()->query()
                ->orderBy('order')
                ->where('status', ActivationStatusEnum::ACTIVE)
                ->where('type', BannerTypeEnum::HOME_BANNER)
                ->where(function($q) use ($now) {
                    $q->where('start_at', '<=', $now)
                        ->where('end_at', '>=', $now)
                        ->orWhereNull('end_at');
                })
                ->get(['label', 'cta_label', 'redirect_url', 'description', 'desktop_image', 'mobile_image', 'color'])
                ->toArray();
        });
    }
}