<?php

namespace App\Repositories;

use App\Models\Inventory;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\InventoryRepositoryContract;

class InventoryRepository extends BaseRepository implements InventoryRepositoryContract
{
    public function model()
    {
        return Inventory::class;
    }
}
