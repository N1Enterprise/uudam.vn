<?php

namespace App\Services\StoreFront;

use App\Enum\ActivationStatusEnum;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class UserSearchService extends BaseService
{
    public function __construct()
    {

    }

    public function suggest($data = [])
    {
        $query = data_get($data, 'q', '');
        $resourcesTypes = data_get($data, 'resources.type', []);
        $resourcesLimits = data_get($data, 'resources.limit', []);

        $posts = [];
        $inventories = [];
        $collections = [];

        if (in_array('post', $resourcesTypes)) {
            $posts = DB::table('posts')
                ->select(['id', 'slug', 'name', 'image'])
                ->where('status', ActivationStatusEnum::ACTIVE)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('slug', 'LIKE', '%'.$query.'%');
                })
                ->limit(data_get($resourcesLimits, 'post', 4))
                ->get();
        }

        if (in_array('product', $resourcesTypes)) {
            $inventories = DB::table('inventories')
                ->select(['id', 'slug', 'title', 'image'])
                ->where('status', ActivationStatusEnum::ACTIVE)
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', '%'.$query.'%')
                        ->orWhere('slug', 'LIKE', '%'.$query.'%')
                            ->orWhere('sku', 'LIKE', '%'.$query.'%');
                })
                ->limit(data_get($resourcesLimits, 'product', 4))
                ->get();
        }

        if (in_array('collection', $resourcesTypes)) {
            $collections = DB::table('collections')
                ->select(['id', 'name', 'slug', 'primary_image'])
                ->where('status', ActivationStatusEnum::ACTIVE)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('slug', 'LIKE', '%'.$query.'%');
                })
                ->limit(data_get($resourcesLimits, 'collection', 4))
                ->get();
        }

        return [
            'posts' => $posts,
            'inventories' => $inventories,
            'collections' => $collections,
        ];
    }
}
