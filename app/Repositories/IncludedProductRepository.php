<?php

namespace App\Repositories;

use App\Models\IncludedProduct;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IncludedProductRepositoryContract;

class IncludedProductRepository extends BaseRepository implements IncludedProductRepositoryContract
{
    public function model()
    {
        return IncludedProduct::class;
    }
}
