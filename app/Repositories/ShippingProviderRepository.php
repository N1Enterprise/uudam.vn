<?php

namespace App\Repositories;

use App\Models\ShippingProvider;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ShippingProviderRepositoryContract;

class ShippingProviderRepository extends BaseRepository implements ShippingProviderRepositoryContract
{
    public function model()
    {
        return ShippingProvider::class;
    }
}
