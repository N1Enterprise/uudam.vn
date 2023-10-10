<?php

namespace App\Repositories;

use App\Models\PostCategory;
use App\Repositories\Contracts\PostCategoryRepositoryContract;

class PostCategoryRepository extends BaseRepository implements PostCategoryRepositoryContract
{
    public function model()
    {
        return PostCategory::class;
    }
}
