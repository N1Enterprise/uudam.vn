<?php

namespace App\Services;

use App\Repositories\Contracts\ShippingProviderRepositoryContract;
use App\Services\BaseService;

class ShippingProviderService extends BaseService
{
    public $shippingProviderRepository;
    public $addressService;

    public function __construct(ShippingProviderRepositoryContract $shippingProviderRepository, AddressService $addressService)
    {
        $this->shippingProviderRepository = $shippingProviderRepository;
        $this->addressService = $addressService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->shippingProviderRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->shippingProviderRepository
            ->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function getAvailabelByIds($ids = [], $data = [])
    {
        return $this->shippingProviderRepository
            ->modelScopes(['active'])
            ->scopeQuery(function($q) use ($ids) {
                $q->whereIn('id', $ids);
            })
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->shippingProviderRepository->create($attributes);
    }

    public function update($attributes = [], $id)
    {
        return $this->shippingProviderRepository->update($attributes, $id);
    }

    public function show($id, $data = [])
    {
        return $this->shippingProviderRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }
}
