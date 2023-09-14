<?php

namespace App\Repositories;

use App\Models\CategoryGroup;
use App\Repositories\Contracts\CategoryGroupRepositoryContract;

class CategoryGroupRepository extends BaseRepository implements CategoryGroupRepositoryContract
{
    public function model()
    {
        return CategoryGroup::class;
    }
}
