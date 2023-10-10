<?php

namespace App\Services;

use App\Repositories\Contracts\MenuSubGroupRepositoryContract;
use App\Services\BaseService;

class MenuSubGroupService extends BaseService
{
    public $menuSubGroupService;

    public function __construct(MenuSubGroupRepositoryContract $menuSubGroupService)
    {
        $this->menuSubGroupService = $menuSubGroupService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->menuSubGroupService
            ->with(['menuGroup'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->menuSubGroupService->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->menuSubGroupService->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->menuSubGroupService->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->menuSubGroupService->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->menuSubGroupService->delete($id);
    }
}
