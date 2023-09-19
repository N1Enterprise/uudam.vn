<?php

namespace App\Services;

use App\Repositories\Contracts\InventoryRepositoryContract;
use Illuminate\Support\Facades\DB;

class InventoryService extends BaseService
{
    public $inventoryRepository;

    public function __construct(InventoryRepositoryContract $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->inventoryRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function show($id, $data = [])
    {
        return $this->inventoryRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $inventory = $this->inventoryRepository->create($attributes);

            return $inventory;
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $inventory = $this->inventoryRepository->update($attributes, $id);

            return $inventory;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function() use ($id) {
            $status = $this->inventoryRepository->delete($id);

            return $status;
        });
    }
}
