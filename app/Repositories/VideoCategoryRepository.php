<?php

namespace App\Repositories;

use App\Models\VideoCategory;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\VideoCategoryRepositoryContract;

class VideoCategoryRepository extends BaseRepository implements VideoCategoryRepositoryContract
{
    public function model()
    {
        return VideoCategory::class;
    }
}
