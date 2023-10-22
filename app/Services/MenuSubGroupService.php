<?php

namespace App\Services;

use App\Repositories\Contracts\MenuSubGroupRepositoryContract;
use App\Services\BaseService;

class MenuSubGroupService extends BaseService
{
    public $menuSubGroupRepository;

    public function __construct(MenuSubGroupRepositoryContract $menuSubGroupRepository)
    {
        $this->menuSubGroupRepository = $menuSubGroupRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->menuSubGroupRepository
            ->with(['menuGroup'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->menuSubGroupRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->menuSubGroupRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->menuSubGroupRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->menuSubGroupRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->menuSubGroupRepository->delete($id);
    }
}
