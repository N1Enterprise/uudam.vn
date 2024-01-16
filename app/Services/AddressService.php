<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\User;
use App\Repositories\Contracts\AddressRepositoryContract;
use Illuminate\Support\Facades\DB;

class AddressService extends BaseService
{
    public $addressRepository;

    public function __construct(AddressRepositoryContract $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function createByUser($attributes = [], $user)
    {
        return DB::transaction(function() use ($attributes, $user) {
            $attributes['code'] = $this->generateAddressCode();

            $address = $this->addressRepository->create(
                array_merge($attributes, [
                    'addressable_id'   => BaseModel::getModelKey($user),
                    'addressable_type' => User::class
                ])
            );

            if ($address->is_default) {
                $this->addressRepository->getNewModel()->query()
                    ->where('is_default', true)
                    ->where('id', '<>', $address->id)
                    ->update(['is_default' => false]);
            }

            return $address;
        });
    }

    public function getDefaultByUserId($userId)
    {
        $user = UserService::make()->show($userId);

        return $this->addressRepository
            ->scopeQuery(function($q) use ($user) {
                $q->where('addressable_id', BaseModel::getModelKey($user));
            })
            ->addSort('is_default')
            ->addSort('id')
            ->first();
    }

    public function listByUser($userId)
    {
        $user = UserService::make()->show($userId);

        return $this->addressRepository
            ->scopeQuery(function($q) use ($user) {
                $q->where('addressable_id', BaseModel::getModelKey($user));
            })
            ->addSort('is_default')
            ->addSort('id')
            ->all();
    }

    public function generateAddressCode()
    {
        $addressCode = mt_rand(1000, 99999999);

        while($this->addressRepository->exists(['code' => $addressCode])) {
            $addressCode = mt_rand(1000, 9999999999);
        }

        return $addressCode;
    }
}
