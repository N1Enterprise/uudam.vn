<?php

namespace App\Services;

use App\Repositories\Contracts\ShippingZoneRepositoryContract;
use App\Services\BaseService;

class ShippingZoneService extends BaseService
{
    public $shippingZoneRepository;
    public $addressService;

    public function __construct(
        ShippingZoneRepositoryContract $shippingZoneRepository,
        AddressService $addressService
    ) {
        $this->shippingZoneRepository = $shippingZoneRepository;
        $this->addressService = $addressService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->shippingZoneRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->shippingZoneRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->shippingZoneRepository->create($attributes);
    }

    public function update($attributes = [], $id)
    {
        return $this->shippingZoneRepository->update($attributes, $id);
    }

    public function show($id, $data = [])
    {
        return $this->shippingZoneRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function getByAddressId($addressId)
    {
        $address = $this->addressService->show($addressId);

        return $this->shippingZoneRepository
            ->modelScopes(['active'])
            ->scopeQuery(function($q) use ($address) {
                $q->whereJsonContains('supported_provinces', $address->province_code)
                    ->whereJsonContains('supported_districts', $address->district_code);
            })
            ->addSort('created_at')
            ->first();
    }
}
