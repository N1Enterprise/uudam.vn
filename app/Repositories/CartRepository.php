<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\CartRepositoryContract;

class CartRepository extends BaseRepository implements CartRepositoryContract
{
    public function model()
    {
        return Cart::class;
    }
}
