<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\MenuRepositoryContract;

class MenuRepository extends BaseRepository implements MenuRepositoryContract
{
    public function model()
    {
        return Menu::class;
    }
}
