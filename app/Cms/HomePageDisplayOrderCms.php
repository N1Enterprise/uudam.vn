<?php

namespace App\Cms;

use App\Common\Cache;
use App\Models\HomePageDisplayOrder;
use App\Repositories\Contracts\HomePageDisplayOrderRepositoryContract;
use Illuminate\Contracts\Container\BindingResolutionException;

class HomePageDisplayOrderCms extends BaseCms
{
    public const CACHE_TAG = 'home_page_display_cms';

    /**
     * @return HomeDisplayOrder
     * @throws BindingResolutionException
     */
    public function model()
    {
        return app(HomePageDisplayOrder::class);
    }

    public function available()
    {
        $cacheKey = 'available';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return app(HomePageDisplayOrderRepositoryContract::class)
                ->with(['items' => function($q) {
                    $q->where('status', 1)
                        ->where('display_on_frontend', 1)
                            ->orderBy('order');
                }])
                ->modelScopes(['active', 'feDisplay'])
                ->orderBy('order')
                ->all(['id', 'name', 'hidden_name'])
                ->toArray();
        });
    }
}
