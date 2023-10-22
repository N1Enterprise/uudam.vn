<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AttributeValueRepositoryContract;

class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryContract
{
    public function model()
    {
        return AttributeValue::class;
    }
}
