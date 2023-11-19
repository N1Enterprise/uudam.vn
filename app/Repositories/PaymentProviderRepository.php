<?php

namespace App\Repositories;

use App\Models\PaymentProvider;
use App\Repositories\Contracts\PaymentProviderRepositoryContract;

class PaymentProviderRepository extends BaseRepository implements PaymentProviderRepositoryContract
{
    public function model()
    {
        return PaymentProvider::class;
    }
}
