<?php

namespace App\Repositories;

use App\Models\ShippingZone;
use App\Repositories\Contracts\ShippingZoneRepositoryContract;

class ShippingZoneRepository extends BaseRepository implements ShippingZoneRepositoryContract
{
    public function model()
    {
        return ShippingZone::class;
    }
}
