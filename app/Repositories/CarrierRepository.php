<?php

namespace App\Repositories;

use App\Models\Carrier;
use App\Repositories\Contracts\CarrierRepositoryContract;

class CarrierRepository extends BaseRepository implements CarrierRepositoryContract
{
    public function model()
    {
        return Carrier::class;
    }
}
