<?php

namespace App\Services;

use App\Repositories\Contracts\HomePageDisplayOrderRepositoryContract;
use App\Services\BaseService;

class HomePageDisplayOrderService extends BaseService
{
    public $homePageDisplayOrderRepository;

    public function __construct(HomePageDisplayOrderRepositoryContract $homePageDisplayOrderRepository)
    {
        $this->homePageDisplayOrderRepository = $homePageDisplayOrderRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->homePageDisplayOrderRepository
            ->whereColumnsLike($data['query'] ?? null, ['name', 'id'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->homePageDisplayOrderRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->homePageDisplayOrderRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->homePageDisplayOrderRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->homePageDisplayOrderRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->homePageDisplayOrderRepository->delete($id);
    }

    public function searchAvailableByGuest($data = [])
    {
        $data = $this->homePageDisplayOrderRepository
            ->with(['items' => function($q) {
                $q->where('status', 1)
                    ->where('display_on_frontend', 1)
                        ->orderBy('order');
            }])
            ->modelScopes(['active', 'feDisplay'])
            ->orderBy('order')
            ->all(['id', 'name']);

        return $data;
    }
}
