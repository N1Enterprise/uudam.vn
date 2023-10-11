<?php

namespace App\Services;

use App\Repositories\Contracts\MenuGroupRepositoryContract;
use App\Services\BaseService;

class MenuGroupService extends BaseService
{
    public $menuGroupRepository;

    public function __construct(MenuGroupRepositoryContract $menuGroupRepository)
    {
        $this->menuGroupRepository = $menuGroupRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->menuGroupRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->menuGroupRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->menuGroupRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->menuGroupRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->menuGroupRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->menuGroupRepository->delete($id);
    }
}
