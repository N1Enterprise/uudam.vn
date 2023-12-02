<?php

namespace App\Repositories;

use App\Models\OrderItem;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\OrderItemRepositoryContract;

class OrderItemRepository extends BaseRepository implements OrderItemRepositoryContract
{
    public function model()
    {
        return OrderItem::class;
    }
}
