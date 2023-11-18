<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Repositories\Contracts\CarrierRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class CarrierService extends BaseService
{
    public $carrierRepository;

    public function __construct(CarrierRepositoryContract $carrierRepository)
    {
        $this->carrierRepository = $carrierRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->carrierRepository
            ->whereColumnsLike($data['query'] ?? null, ['name', 'email', 'phone'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->carrierRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function() use ($attributes) {
            if ($logo = data_get($attributes, 'logo')) {
                $attributes['logo'] = ImageHelper::make('shipping')->uploadImage($logo);
            }

            return $this->carrierRepository->create($attributes);
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function() use ($attributes, $id) {
            if ($logo = data_get($attributes, 'logo')) {
                $attributes['logo'] = ImageHelper::make('shipping')->uploadImage($logo);
            }

            return $this->carrierRepository->update($attributes, $id);
        });
    }

    public function show($id, $data = [])
    {
        return $this->carrierRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }
}
