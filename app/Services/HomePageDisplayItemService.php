<?php

namespace App\Services;

use App\Repositories\Contracts\HomePageDisplayItemRepositoryContract;
use App\Services\BaseService;

class HomePageDisplayItemService extends BaseService
{
    public $homePageDisplayItemRepository;

    public function __construct(HomePageDisplayItemRepositoryContract $homePageDisplayItemRepository)
    {
        $this->homePageDisplayItemRepository = $homePageDisplayItemRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->homePageDisplayItemRepository
            ->with(['group'])
            ->whereColumnsLike($data['query'] ?? null, ['id'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->homePageDisplayItemRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->homePageDisplayItemRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->homePageDisplayItemRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->homePageDisplayItemRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->homePageDisplayItemRepository->delete($id);
    }
}
