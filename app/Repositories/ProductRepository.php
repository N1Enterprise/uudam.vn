<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ProductRepositoryContract;

class ProductRepository extends BaseRepository implements ProductRepositoryContract
{
    public function model()
    {
        return Product::class;
    }
}
