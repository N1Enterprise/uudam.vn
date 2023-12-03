<?php

namespace App\Repositories;

use App\Models\SystemCurrency;
use App\Repositories\Contracts\SystemCurrencyRepositoryContract;

class SystemCurrencyRepository extends BaseRepository implements SystemCurrencyRepositoryContract
{
    public function model()
    {
        return SystemCurrency::class;
    }
}
