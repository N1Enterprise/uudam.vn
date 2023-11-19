<?php

namespace App\Repositories;

use App\Models\ShippingRate;
use App\Repositories\Contracts\ShippingRateRepositoryContract;

class ShippingRateRepository extends BaseRepository implements ShippingRateRepositoryContract
{
    public function model()
    {
        return ShippingRate::class;
    }
}
