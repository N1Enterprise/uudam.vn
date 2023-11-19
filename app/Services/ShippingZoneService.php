<?php

namespace App\Services;

use App\Repositories\Contracts\ShippingZoneRepositoryContract;
use App\Services\BaseService;

class ShippingZoneService extends BaseService
{
    public $shippingZoneRepository;

    public function __construct(ShippingZoneRepositoryContract $shippingZoneRepository)
    {
        $this->shippingZoneRepository = $shippingZoneRepository;
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
}
