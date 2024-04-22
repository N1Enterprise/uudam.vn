<?php

namespace App\Services;

use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class UserSearchService extends BaseService
{
    public function suggest($data = [])
    {
        $query = data_get($data, 'q', '');
        $resourcesTypes = data_get($data, 'resources.type', []);
        $resourcesLimits = data_get($data, 'resources.limit', []);

        $posts = [];
        $inventories = [];
        $collections = [];
        $videos = [];

        $customSearchKeyworkds = SystemSetting::from(SystemSettingKeyEnum::SEARCH_SETTING)->get('custom_search_keyworkds', []);

        if (in_array('post', $resourcesTypes)) {
            $posts = DB::table('posts')
                ->select(['id', 'slug', 'name', 'image'])
                ->where('status', 1)
                ->where('display_on_frontend', 1)
                ->where('allow_frontend_search', 1)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('slug', 'LIKE', '%'.$query.'%');
                })
                ->limit(data_get($resourcesLimits, 'post', 4))
                ->get();
        }

        if (in_array('product', $resourcesTypes)) {
            $inventories = DB::table('inventories')
                ->select([
                    'inventories.id',
                    'inventories.slug',
                    'inventories.title',
                    'inventories.image',
                    'inventories.meta_keywords',
                    'inventories.sale_price',
                    'inventories.offer_price',
                ])
                ->where('inventories.status', 1)
                ->where('inventories.display_on_frontend', 1)
                ->where('inventories.allow_frontend_search', 1)
                ->where(function($q) use ($query) {
                    $q->where('inventories.title', 'LIKE', '%'.$query.'%')
                        ->orWhere('inventories.meta_keywords', 'LIKE', '%'.$query.'%')
                        ->orWhere('inventories.sku', 'LIKE', '%'.$query.'%')
                        ->orWhere('inventories.sale_price', 'LIKE', '%'.$query.'%')
                        ->orWhere('inventories.offer_price', 'LIKE', '%'.$query.'%')
                        ->orWhere('inventories.slug', 'LIKE', '%'.$query.'%');

                    $q->whereIn('inventories.id', function($query) {
                        $query->select(DB::raw('MIN(id)'))
                            ->from('inventories')
                            ->groupBy('product_id');
                    });
                })
                ->orderBy('inventories.sold_count', 'desc')
                ->limit(data_get($resourcesLimits, 'product', 4))
                ->get();
        }

        if (in_array('collection', $resourcesTypes)) {
            $collections = DB::table('collections')
                ->select(['id', 'name', 'slug', 'primary_image'])
                ->where('status', 1)
                ->where('display_on_frontend', 1)
                ->where('allow_frontend_search', 1)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('slug', 'LIKE', '%'.$query.'%');
                })
                ->limit(data_get($resourcesLimits, 'collection', 4))
                ->get();
        }

        if (in_array('video', $resourcesTypes)) {
            $videos = DB::table('videos')
                ->select(['id', 'name', 'slug', 'thumbnail'])
                ->where('status', 1)
                ->where('display_on_frontend', 1)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('slug', 'LIKE', '%'.$query.'%');
                })
                ->limit(data_get($resourcesLimits, 'video', 4))
                ->get();;
        }

        $otherSearch = collect($customSearchKeyworkds)
            ->filter(function($item) use ($query) {
                $filtered = array_filter(data_get($item, 'keywords', []), function($keyword) use ($query) {
                    return str_contains(strtolower($keyword), strtolower($query));
                });

                return data_get($item, 'active') && !empty($filtered);
            })
            ->map(function($item) {
                return [
                    'image' => data_get($item, 'image'),
                    'name' => data_get($item, 'name'),
                    'link' => data_get($item, 'link'),
                    'open_new_tab'  => data_get($item, 'open_new_tab'),
                ];
            })
            ->values();

        return [
            'posts' => $posts,
            'inventories' => $inventories,
            'collections' => $collections,
            'videos' => $videos,
            'othersearch' => $otherSearch,
        ];
    }
}
