<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\User;
use App\Repositories\Contracts\AddressRepositoryContract;

class AddressService extends BaseService
{
    public $addressRepository;

    public function __construct(AddressRepositoryContract $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function createByUser($attributes = [], $user)
    {
        return $this->addressRepository->create(
            array_merge($attributes, [
                'addressable_id'   => BaseModel::getModelKey($user),
                'addressable_type' => User::class
            ])
        );
    }
}
