<?php

namespace App\Repositories;

use App\Models\HomePageDisplayOrder;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\HomePageDisplayOrderRepositoryContract;

class HomePageDisplayOrderRepository extends BaseRepository implements HomePageDisplayOrderRepositoryContract
{
    public function model()
    {
        return HomePageDisplayOrder::class;
    }
}
