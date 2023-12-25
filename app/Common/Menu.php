<?php

namespace App\Common;

use App\Models\MenuGroup;

class Menu
{
    public const CACHE_TAG = 'menu';

    public static function getMenus()
    {
        $cacheKey = 'menu_groups';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return self::menuGroups();
        });
    }

    public static function menuGroups()
    {
        return MenuGroup::with([
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
        ->get([ 'id', 'name', 'order', 'params']);
    }
}
