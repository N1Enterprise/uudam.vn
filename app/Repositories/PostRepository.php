<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\PostRepositoryContract;

class PostRepository extends BaseRepository implements PostRepositoryContract
{
    public function model()
    {
        return Post::class;
    }
}
