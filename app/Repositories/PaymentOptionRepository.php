<?php

namespace App\Repositories;

use App\Models\PaymentOption;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\PaymentOptionRepositoryContract;

class PaymentOptionRepository extends BaseRepository implements PaymentOptionRepositoryContract
{
    public function model()
    {
        return PaymentOption::class;
    }
}
