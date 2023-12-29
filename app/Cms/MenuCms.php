<?php

namespace App\Cms;

use App\Common\Cache;
use App\Models\Menu;
use App\Models\MenuGroup;

class MenuCms extends BaseCms
{
    public const CACHE_TAG = 'menu_cms';

    /**
     * @return Menu
     * @throws BindingResolutionException 
     */
    public function model()
    {
        return app(MenuGroup::class);
    }

    public function availabel()
    {
        $cacheKey = 'availabel';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return $this->model()->query()
                ->with([
                    'menuSubGroups' => function($q) {
                        $q->where('status', 1)
                            ->orderBy('order')
                            ->where('display_on_frontend', 1);
                    },
                    'menuSubGroups.menus' => function($q) {
                        $q->where('status', 1)
                            ->orderBy('order')
                            ->where('display_on_frontend', 1);
                    },
                    'menuSubGroups.menus.collection' => function($q) {
                        $q->where('status', 1)
                            ->where('display_on_frontend', 1);
                    },
                    'menuSubGroups.menus.inventory' => function($q) {
                        $q->where('status', 1);
                    },
                    'menuSubGroups.menus.post' => function($q) {
                        $q->where('status', 1)
                            ->where('display_on_frontend', 1);
                    },
                ])
                ->orderBy('order')
                ->get(['id', 'name', 'order', 'params'])
                ->toArray();
        });
    }
}