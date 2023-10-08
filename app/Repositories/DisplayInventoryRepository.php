<?php

namespace App\Repositories;

use App\Models\DisplayInventory;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\DisplayInventoryRepositoryContract;

class DisplayInventoryRepository extends BaseRepository implements DisplayInventoryRepositoryContract
{
    public function model()
    {
        return DisplayInventory::class;
    }
}
