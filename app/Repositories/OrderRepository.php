<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\OrderRepositoryContract;

class OrderRepository extends BaseRepository implements OrderRepositoryContract
{
    public function model()
    {
        return Order::class;
    }
}
