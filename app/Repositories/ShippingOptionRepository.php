<?php

namespace App\Repositories;

use App\Models\ShippingOption;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ShippingOptionRepositoryContract;

class ShippingOptionRepository extends BaseRepository implements ShippingOptionRepositoryContract
{
    public function model()
    {
        return ShippingOption::class;
    }
}
