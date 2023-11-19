<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\CartItemRepositoryContract;

class CartItemRepository extends BaseRepository implements CartItemRepositoryContract
{
    public function model()
    {
        return CartItem::class;
    }
}
