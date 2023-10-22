<?php

namespace App\Repositories;

use App\Models\MenuGroup;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\MenuGroupRepositoryContract;

class MenuGroupRepository extends BaseRepository implements MenuGroupRepositoryContract
{
    public function model()
    {
        return MenuGroup::class;
    }
}
