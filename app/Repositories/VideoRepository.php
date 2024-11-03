<?php

namespace App\Repositories;

use App\Models\Video;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\VideoRepositoryContract;

class VideoRepository extends BaseRepository implements VideoRepositoryContract
{
    public function model()
    {
        return Video::class;
    }
}
