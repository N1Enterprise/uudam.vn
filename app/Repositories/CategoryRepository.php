<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryContract;

class CategoryRepository extends BaseRepository implements CategoryRepositoryContract
{
    public function model()
    {
        return Category::class;
    }
}
