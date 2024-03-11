<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AddressRepositoryContract;

class AddressRepository extends BaseRepository implements AddressRepositoryContract
{
    public function model()
    {
        return Address::class;
    }
}
