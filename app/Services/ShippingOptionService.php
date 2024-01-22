<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\ShippingOption;
use App\Repositories\Contracts\ShippingOptionRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class ShippingOptionService extends BaseService
{
    public $shippingOptionRepository;

    public function __construct(ShippingOptionRepositoryContract $shippingOptionRepository)
    {
        $this->shippingOptionRepository = $shippingOptionRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->shippingOptionRepository
            ->with(['shippingProvider'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function create($attributes = [])
    {
        return DB::transaction(function() use ($attributes) {
            if ($logo = data_get($attributes, 'logo')) {
                $attributes['logo'] = ImageHelper::make('shipping')
                    ->hasOptimization()
                    ->setConfigKey([ShippingOption::class, 'logo'])
                    ->uploadImage($logo);
            }

            return $this->shippingOptionRepository->create($attributes);
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function() use ($attributes, $id) {
            if ($logo = data_get($attributes, 'logo')) {
                $attributes['logo'] = ImageHelper::make('shipping')
                    ->hasOptimization()
                    ->setConfigKey([ShippingOption::class, 'logo'])
                    ->uploadImage($logo);
            }

            return $this->shippingOptionRepository->update($attributes, $id);
        });
    }

    public function show($id, $data = [])
    {
        return $this->shippingOptionRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function allAvailableByProvinceCodeForUser($provinceCode)
    {
        return $this->shippingOptionRepository
            ->modelScopes(['active', 'feDisplay'])
            ->scopeQuery(function($q) use ($provinceCode) {
                $q->whereJsonContains('supported_provinces', $provinceCode);
            })
            ->orderBy('order')
            ->all();
    }
}
