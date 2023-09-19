<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AttributeRepositoryContract;

class AttributeRepository extends BaseRepository implements AttributeRepositoryContract
{
    public function model()
    {
        return Attribute::class;
    }
}
