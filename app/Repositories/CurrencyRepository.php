<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryContract;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryContract
{
    public function model()
    {
        return Currency::class;
    }
}
