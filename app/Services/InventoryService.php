<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\Inventory;
use App\Repositories\Contracts\InventoryRepositoryContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            ->with(['product', 'createdBy', 'updatedBy'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->inventoryRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function show($id, $data = [])
    {
        return $this->inventoryRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function findBySlug($slug, $data = [])
    {
        return $this->inventoryRepository
            ->modelScopes(data_get($data, 'scopes', []))
            ->with(data_get($data, 'with', []))
            ->firstByField('slug', $slug, data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function() use ($attributes) {
            $attributes['image'] = $this->convertImage(data_get($attributes, ['image']));
            $attributes['slug'] = Str::slug($attributes['product_slug'] . ' ' . $attributes['sku'], '-');

            $inventory = $this->inventoryRepository->create($attributes);

            return $inventory;
        });
    }

    public function createWithVariants($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $variants = data_get($attributes, 'variants', []);
            $skus = array_filter(Arr::wrap(data_get($variants, 'sku', [])));

            $variant['title'] = data_get($attributes, 'title');
            $variant['product_id'] = data_get($attributes, 'product_id');
            $variant['condition_note'] = data_get($attributes, 'condition_note');
            $variant['status'] = data_get($attributes, 'status');
            $variant['description'] = data_get($attributes, 'description');
            $variant['key_features'] = Arr::wrap(data_get($attributes, 'key_features', []));
            $variant['min_order_quantity'] = data_get($attributes, 'min_order_quantity');
            $variant['available_from'] = data_get($attributes, 'available_from');
            $variant['meta_title'] = data_get($attributes, 'meta_title');
            $variant['meta_description'] = data_get($attributes, 'meta_description');
            $variant['product_slug'] = data_get($attributes, 'product_slug');
            $variant['offer_start'] = data_get($attributes, 'offer_start');
            $variant['offer_end'] = data_get($attributes, 'offer_end');


            $variantsCreated = [];

            foreach ($skus as $index => $sku) {
                $variant['condition'] = data_get($variants, ['condition', $index]);
                $variant['sku'] = $sku;
                $variant['purchase_price'] = data_get($variants, ['purchase_price', $index]);
                $variant['sale_price'] = data_get($variants, ['sale_price', $index]);
                $variant['offer_price'] = data_get($variants, ['offer_price', $index]);
                $variant['offer_start'] = $variant['offer_price'] ? $variant['offer_start'] : null;
                $variant['offer_end'] = $variant['offer_price'] ? $variant['offer_end'] : null;
                $variant['stock_quantity'] = data_get($variants, ['stock_quantity', $index]);
                $variant['slug'] = Str::slug($variant['product_slug'] . ' ' . $sku, '-');
                $variant['image'] = $this->convertImage(data_get($variants, ['image', $index]));

                $inventory = $this->inventoryRepository->create($variant);

                if ($attributes = Arr::wrap(data_get($variants, ['attribute', $index], []))) {
                    $this->setAttributes($inventory, $attributes);
                }

                $variantsCreated[] = $inventory;
            }

            return $variantsCreated;
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = $this->convertImage(data_get($attributes, 'image'));

            $inventory = $this->inventoryRepository->update($attributes, $id);

            $this->setAttributes($inventory, data_get($attributes, ['variants', 'attribute'], []));

            return $inventory;
        });
    }

    public function delete($id)
    {
        return $this->inventoryRepository->delete($id);
    }

    protected function setAttributes(Inventory $inventory, $attributes = [])
    {
        $data = [];

        foreach ($attributes as $attribute_id => $attribute_value_id){
            $data[$attribute_id] = ['attribute_value_id' => $attribute_value_id];
        }

        if (! empty($data)){
            $inventory->attributes()->sync($data);
        }

        return true;
    }

    protected function convertImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            $imageFile = data_get($image, 'file');
            $filename  = $this->catalogDisk()->putFile('/', $imageFile);
            $imageUrl = $this->catalogDisk()->url($filename);

            return $imageUrl;
        }

        return null;
    }

    protected function catalogDisk()
    {
        return Storage::disk('catalog');
    }

    public function listAvailableByProduct($product, $data = [])
    {
        $inventories = $this->inventoryRepository
            ->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->scopeQuery(function($q) use ($product) {
                $q->where('product_id', BaseModel::getModelKey($product));
            })
            ->all(data_get($data, 'columns', ['*']));

        return $inventories;
    }

    public function getInventoryAttributesByVariants($inventory, $variants)
    {
        $attrPivots = DB::table('attribute_inventories')
            ->select('attribute_id','inventory_id','attribute_value_id')
            ->whereIn('inventory_id', $variants->pluck('id'))->get();

        $inventoryAttributes = $attrPivots
            ->where('inventory_id', $inventory->id)
            ->pluck('attribute_value_id')
            ->toArray();

    }
}
