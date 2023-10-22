<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\CollectionRepositoryContract;

class CollectionRepository extends BaseRepository implements CollectionRepositoryContract
{
    public function model()
    {
        return Collection::class;
    }
}
