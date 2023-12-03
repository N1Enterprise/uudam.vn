<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\ProductCombo;
use App\Repositories\Contracts\ProductComboRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class ProductComboService extends BaseService
{
    public $productComboRepository;

    public function __construct(ProductComboRepositoryContract $productComboRepository)
    {
        $this->productComboRepository = $productComboRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->productComboRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->productComboRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['image'] = ImageHelper::make('catalog')
                ->hasOptimization()
                ->setConfigKey([ProductCombo::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            return $this->productComboRepository->create($attributes);
        });
    }

    public function show($id, $columns = ['*'])
    {
        return $this->productComboRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = ImageHelper::make('catalog')
                ->hasOptimization()
                ->setConfigKey([ProductCombo::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            return $this->productComboRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->productComboRepository->delete($id);
    }
}
