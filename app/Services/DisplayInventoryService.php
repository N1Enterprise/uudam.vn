<?php

namespace App\Services;

use App\Repositories\Contracts\DisplayInventoryRepositoryContract;
use App\Services\BaseService;

class DisplayInventoryService extends BaseService
{
    public $displayInventoryRepository;

    public function __construct(DisplayInventoryRepositoryContract $displayInventoryRepository)
    {
        $this->displayInventoryRepository = $displayInventoryRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->displayInventoryRepository
            ->with(['inventory'])
            ->scopeQuery(function($q) use ($data) {
                if ($inventoryTitle = data_get($data, 'inventory_title')) {
                    $q->whereHas('inventory', function($q) use ($inventoryTitle) {
                        $q->where('title', $inventoryTitle);
                    });
                }

                if ($displayType = data_get($data, 'type')) {
                    $q->where('type', $displayType);
                }
            })
            ->whereColumnsLike($data['query'] ?? null, ['type'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->displayInventoryRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->displayInventoryRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->displayInventoryRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->displayInventoryRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->displayInventoryRepository->delete($id);
    }

    public function findByInventoryAndType($inventoryId, $type)
    {
        return $this->displayInventoryRepository->firstWhere([
            'product_id' => $inventoryId,
            'type' => $type,
        ]);
    }

    public function allAvailableByType($type, $data = [])
    {
        return $this->displayInventoryRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->scopeQuery(function($q) use ($type) {
                $q->where('type', $type);
            })
            ->addSort('order', 'desc')
            ->all(data_get($data, 'columns', ['*']));
    }
}
