<?php

namespace App\Services;

use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                $attributes['meta']['image'] = $this->convertImage($image);
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
                $attributes['meta']['image'] = $this->convertImage($image);
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

    protected function convertImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            $imageFile = data_get($image, 'file');
            $filename  = $this->appearanceDisk()->putFile('/', $imageFile);
            $imageUrl = $this->appearanceDisk()->url($filename);

            return $imageUrl;
        }

        return null;
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

    protected function appearanceDisk()
    {
        return Storage::disk('appearance');
    }
}
