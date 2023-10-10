<?php

namespace App\Services;

use App\Repositories\Contracts\MenuRepositoryContract;
use App\Services\BaseService;

class MenuService extends BaseService
{
    public $menuService;

    public function __construct(MenuRepositoryContract $menuService)
    {
        $this->menuService = $menuService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->menuService
            ->with(['menuSubGroups'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->menuService->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->menuService->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->menuService->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->menuService->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->menuService->delete($id);
    }
}
