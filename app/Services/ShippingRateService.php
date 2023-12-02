<?php

namespace App\Services;

use App\Repositories\Contracts\ShippingRateRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

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
            ->with(['shippingZone', 'carrier'])
            ->whereColumnsLike(data_get($data, 'query') ?? null, ['name'])
            ->whereColumnsLike(data_get($data, 'shipping_zone_id') ?? null, ['shipping_zone_id'])
            ->whereColumnsLike(data_get($data, 'carrier_id') ?? null, ['carrier_id'])
            ->whereColumnsLike(data_get($data, 'type') ?? null, ['type'])
            ->search([]);

        return $result;
    }

    public function searchByUser($data = [])
    {
        $result = $this->shippingRateRepository
            ->with(['shippingZone', 'carrier'])
            ->modelScopes(['active', 'feDisplay'])
            ->scopeQuery(function($q) use ($data) {
                if ($type = data_get($data, 'type')) {
                    $q->where('type', $type);
                }

                if ($value = data_get($data, 'value')) {
                    $q->where('minimum', '<=', $value);
                    $q->where(function($q) use ($value) {
                        $q->where('maximum', '>=', $value)
                            ->orWhereNull('maximum');
                    });
                }
            });

        $result = $result->search([], null, ['*'], false);

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
}
