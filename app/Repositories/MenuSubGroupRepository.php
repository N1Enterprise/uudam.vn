<?php

namespace App\Repositories;

use App\Models\MenuSubGroup;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\MenuSubGroupRepositoryContract;

class MenuSubGroupRepository extends BaseRepository implements MenuSubGroupRepositoryContract
{
    public function model()
    {
        return MenuSubGroup::class;
    }
}
