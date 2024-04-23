<?php

namespace App\Services;

use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MenuService extends BaseService
{
    public $menuRepository;

    public function __construct(MenuRepositoryContract $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->menuRepository
            ->with(['menuCatalogs', 'inventory', 'post'])
            ->whereColumnsLike($data['query'] ?? null, ['name', 'label'])
            ->scopeQuery(function($q) use ($data) {
                if ($type = data_get($data, 'type')) {
                    $q->where('type', $type);
                }

                if ($collectionId = data_get($data, 'collection_id')) {
                    $q->where('collection_id', $collectionId);
                }

                if ($inventoryId = data_get($data, 'inventory_id')) {
                    $q->where('inventory_id', $inventoryId);
                }

                if ($postId = data_get($data, 'post_id')) {
                    $q->where('post_id', $postId);
                }

                $groupIds = Arr::wrap(data_get($data, 'menu_catalogs', []));

                if (! empty($groupIds)) {
                    $q->whereHas('menuCatalogs', function ($q) use ($groupIds) {
                        $q->whereIn('menu_sub_group_id', $groupIds);
                    });
                }
            })
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->menuRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function() use ($attributes) {
            $menu = $this->menuRepository->create($attributes);

            $this->syncMenuCatalogs($menu, data_get($attributes, 'menu_catalogs', []));

            return $menu;
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function() use ($attributes, $id) {
            $menu = $this->menuRepository->update($attributes, $id);

            $this->syncMenuCatalogs($menu, data_get($attributes, 'menu_catalogs', []));

            return $menu;
        });
    }

    protected function syncMenuCatalogs(Menu $menu, $menuCatalogs = [])
    {
        return $menu->menuCatalogs()->sync($menuCatalogs);
    }

    public function show($id, $data = [])
    {
        return $this->menuRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function delete($id)
    {
        return $this->menuRepository->delete($id);
    }
}
