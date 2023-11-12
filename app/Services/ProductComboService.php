<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Repositories\Contracts\ProductComboRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class ProductComboService extends BaseService
{
    public $includedProductRepository;

    public function __construct(ProductComboRepositoryContract $includedProductRepository)
    {
        $this->includedProductRepository = $includedProductRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->includedProductRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->includedProductRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['image'] = ImageHelper::make('catalog')->uploadImage(data_get($attributes, 'image'));

            return $this->includedProductRepository->create($attributes);
        });
    }

    protected function u($image)
    {
        return ImageHelper::make('catalog')->uploadImage($image);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->includedProductRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = ImageHelper::make('catalog')->uploadImage(data_get($attributes, 'image'));

            return $this->includedProductRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->includedProductRepository->delete($id);
    }
}
