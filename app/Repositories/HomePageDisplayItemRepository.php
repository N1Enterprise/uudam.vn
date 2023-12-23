<?php

namespace App\Repositories;

use App\Models\HomePageDisplayItem;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\HomePageDisplayItemRepositoryContract;

class HomePageDisplayItemRepository extends BaseRepository implements HomePageDisplayItemRepositoryContract
{
    public function model()
    {
        return HomePageDisplayItem::class;
    }
}
