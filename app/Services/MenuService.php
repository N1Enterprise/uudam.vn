<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryContract;
use App\Services\BaseService;
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
            ->whereColumnsLike($data['query'] ?? null, ['name'])
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
            if ($image = data_get($attributes, 'meta.image')) {
                $attributes['meta']['image'] = ImageHelper::make('appearance')->uploadImage($image);
            }

            $menu = $this->menuRepository->create($attributes);

            $this->syncMenuCatalogs($menu, data_get($attributes, 'menu_catalogs', []));

            return $menu;
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function() use ($attributes, $id) {
            if ($image = data_get($attributes, 'meta.image')) {
                $attributes['meta']['image'] = ImageHelper::make('appearance')->uploadImage($image);
            }

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
