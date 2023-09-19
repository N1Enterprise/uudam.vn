<?php

namespace App\Repositories;

use App\Models\Inventory;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AttributeRepositoryContract;

class AttributeRepository extends BaseRepository implements AttributeRepositoryContract
{
    public function model()
    {
        return Inventory::class;
    }
}
