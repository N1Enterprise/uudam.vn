<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\InventoryRepositoryContract;

class InventoryRepository extends BaseRepository implements InventoryRepositoryContract
{
    public function model()
    {
        return AttributeValue::class;
    }
}
