<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Contracts\CountryRepositoryContract;

class CountryRepository extends BaseRepository implements CountryRepositoryContract
{
    public function model()
    {
        return Country::class;
    }
}
