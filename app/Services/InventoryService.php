<?php

namespace App\Services;

use App\Repositories\Contracts\InventoryRepositoryContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryService extends BaseService
{
    public $inventoryRepository;

    public function __construct(InventoryRepositoryContract $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->inventoryRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function show($id, $data = [])
    {
        return $this->inventoryRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function create()
    {

    }

    public function createWithVariants($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $variants = data_get($attributes, 'variants', []);
            $skus = array_filter(Arr::wrap(data_get($variants, 'sku', [])));

            foreach ($skus as $index => $sku) {
                $variant['sku']            = $sku;
                $variant['condition']      = data_get($variants, ['condition', $index]);
                $variant['stock_quantity'] = data_get($variants, ['stock_quantity', $index]);
                $variant['purchase_price'] = data_get($variants, ['purchase_price', $index]);
                $variant['sale_price']     = data_get($variants, ['sale_price', $index]);
                $variant['offer_price']    = data_get($variants, ['offer_price', $index]);
                $variant['offer_start']    = $variant['offer_price'] ? data_get($attributes, 'offer_start') : null;
                $variant['offer_end']      = $variant['offer_price'] ? data_get($attributes, 'offer_end') : null;
                $variant['slug']           = Str::slug(data_get($attributes, 'product_slug') . ' ' . $sku, '-');

                dd($variant);
            }
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $inventory = $this->inventoryRepository->update($attributes, $id);

            return $inventory;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function() use ($id) {
            $status = $this->inventoryRepository->delete($id);

            return $status;
        });
    }
}
