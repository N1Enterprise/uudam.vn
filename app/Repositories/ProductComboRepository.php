<?php

namespace App\Repositories;

use App\Models\ProductCombo;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ProductComboRepositoryContract;

class ProductComboRepository extends BaseRepository implements ProductComboRepositoryContract
{
    public function model()
    {
        return ProductCombo::class;
    }
}
