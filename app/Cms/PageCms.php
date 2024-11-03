<?php

namespace App\Cms;

use App\Common\Cache;
use App\Enum\PageDisplayInEnum;
use App\Models\Page;

class PageCms extends BaseCms
{
    public const CACHE_TAG = 'page_cms';

    /**
     * @return Page
     * @throws BindingResolutionException 
     */
    public function model()
    {
        return app(Page::class);
    }

    public function ofFooter()
    {
        $cacheKey = self::CACHE_TAG.':footer';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return $this->model()->query()
                ->whereJsonContains('display_in', PageDisplayInEnum::FOOTER)
                ->where('status', 1)
                ->where('display_on_frontend', 1)
                ->orderBy('order')
                ->get(['name', 'slug'])
                ->toArray();
        });
    }
}