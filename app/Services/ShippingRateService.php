<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Repositories\Contracts\ShippingRateRepositoryContract;
use App\Services\BaseService;

class ShippingRateService extends BaseService
{
    public $shippingRateRepository;

    public function __construct(ShippingRateRepositoryContract $shippingRateRepository)
    {
        $this->shippingRateRepository = $shippingRateRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->shippingRateRepository
            ->with(['shippingZone'])
            ->whereColumnsLike(data_get($data, 'query') ?? null, ['name'])
            ->whereColumnsLike(data_get($data, 'shipping_zone_id') ?? null, ['shipping_zone_id'])
            ->whereColumnsLike(data_get($data, 'carrier_id') ?? null, ['carrier_id'])
            ->whereColumnsLike(data_get($data, 'type') ?? null, ['type'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->shippingRateRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->shippingRateRepository->create($attributes);
    }

    public function update($attributes = [], $id)
    {

        return $this->shippingRateRepository->update($attributes, $id);
    }

    public function show($id, $data = [])
    {
        return $this->shippingRateRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function delete($id)
    {
        return $this->shippingRateRepository->delete($id);
    }

    public function getByShippingZone($shippingZoneId, $type, $value)
    {
        return $this->shippingRateRepository
            ->modelScopes(['active'])
            ->scopeQuery(function($q) use ($shippingZoneId, $type, $value) {
                $q->where('shipping_zone_id', BaseModel::getModelKey($shippingZoneId))
                    ->where('type', $type);

                $q->where('minimum', '<=', $value)
                    ->where(function($q) use ($value) {
                        $q->whereNull('maximum')
                            ->orWhere('maximum', '>=', $value);
                    });
            })
            ->addSort('created_at')
            ->first();
    }
}
