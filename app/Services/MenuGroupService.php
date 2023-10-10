<?php

namespace App\Services;

use App\Repositories\Contracts\MenuGroupRepositoryContract;
use App\Services\BaseService;

class MenuGroupService extends BaseService
{
    public $menuGroupService;

    public function __construct(MenuGroupRepositoryContract $menuGroupService)
    {
        $this->menuGroupService = $menuGroupService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->menuGroupService
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->menuGroupService->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->menuGroupService->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->menuGroupService->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->menuGroupService->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->menuGroupService->delete($id);
    }
}
