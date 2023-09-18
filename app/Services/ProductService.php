<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;

class ProductService extends BaseService
{
    public $productRepository;

    public function __construct(ProductRepositoryContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->productRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function create($attributes = [])
    {

    }

    public function show($id, $columns = ['*'])
    {
    }

    public function update($attributes = [], $id)
    {

    }

    protected function bankSlipDisk()
    {
        return Storage::disk('catalog');
    }
}
