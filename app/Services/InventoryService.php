<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\BaseModel;
use App\Models\Inventory;
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
            ->with(['product', 'createdBy', 'updatedBy'])
            ->whereColumnsLike($data['query'] ?? null, ['id', 'slug', 'sku', 'title'])
            ->scopeQuery(function($q) use ($data) {
                $productId = data_get($data, 'product_id');

                if ($productId) {
                    $q->where('product_id', $productId);
                }

                if ($status = Arr::wrap(data_get($data, 'status'))) {
                    $q->whereIn('status', $status);
                }

                if ($feDisplay = Arr::wrap(data_get($data, 'display_on_frontend'))) {
                    $q->whereIn('display_on_frontend', $feDisplay);
                }

                if ($feSearch = Arr::wrap(data_get($data, 'allow_frontend_search'))) {
                    $q->whereIn('allow_frontend_search', $feSearch);
                }
            })
            ->search([]);

        return $result;
    }

    public function searchForGuest($data = [])
    {
        $where = [];

        $orderBy = 'sale_price';
        $sortBy = 'asc';

        if (! empty(data_get($data, 'sort_by'))) {
            switch (data_get($data, 'sort_by')) {
                case 'manual';
                    $orderBy = 'sale_price';
                    $sortBy = 'asc';
                    break;
                case 'best-selling';
                    $orderBy = 'offer_price';
                    $sortBy = 'asc';
                    break;
                case 'title-ascending':
                    $orderBy = 'title';
                    $sortBy = 'asc';
                    break;
                case 'title-descending':
                    $orderBy = 'title';
                    $sortBy = 'desc';
                    break;
                case 'price-ascending':
                    $orderBy = 'sale_price';
                    $sortBy = 'asc';
                    break;
                case 'price-descending':
                    $orderBy = 'sale_price';
                    $sortBy = 'desc';
                    break;
                case 'created-ascending':
                    $orderBy = 'created_at';
                    $sortBy = 'asc';
                    break;
                case 'created-descending':
                    $orderBy = 'created_at';
                    $sortBy = 'desc';
                    break;
                default:
                    break;
            }
        }

        $result = $this->inventoryRepository
            ->with(data_get($data, 'with', []))
            ->modelScopes(['active', 'feDisplay'])
            ->whereColumnsLike($data['query'] ?? null, ['sku', 'title', 'slug'])
            ->scopeQuery(function($q) use ($data) {
                $filterIds = data_get($data, 'filter_ids', []);

                if (! empty($filterIds)) {
                    $q->whereIn('id', $filterIds);
                }
            })
            ->addSort($orderBy, $sortBy);

        return $result->search($where, null, ['*'], true, data_get($data, 'paging', 'paginate'));
    }

    public function allAvailable($data = [])
    {
        return $this->inventoryRepository
            ->modelScopes(array_merge(['active'], data_get($data, 'scopes', [])))
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function getAvailableByIds($ids = [], $data = [])
    {
        return $this->inventoryRepository
            ->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->scopeQuery(function($q) use ($ids) {
                $q->whereIn('id', $ids);
            })
            ->all(data_get($data, 'columns', ['*']));
    }

    public function show($id, $data = [])
    {
        return $this->inventoryRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function getAvailableBySuggested($suggested, $data = [])
    {
        return $this->inventoryRepository
            ->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->scopeQuery(function($q) use ($suggested) {
                $q->whereIn('id', Arr::wrap($suggested));
            })
            ->all(data_get($data, 'columns'));
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
            $attributes['image'] = ImageHelper::make('catalog')
                ->hasOptimization()
                ->setConfigKey([Inventory::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

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
                $variant['image'] = ImageHelper::make('catalog')
                ->hasOptimization()
                ->setConfigKey([Inventory::class, 'image'])
                ->uploadImage(data_get($variants, ['image', $index]));

                $inventory = $this->inventoryRepository->create($variant);

                if ($invAttributes = Arr::wrap(data_get($variants, ['attribute', $index], []))) {
                    $this->setAttributes($inventory, $invAttributes);
                }

                $variantsCreated[] = $inventory;
            }

            return $variantsCreated;
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = ImageHelper::make('catalog')
                ->hasOptimization()
                ->setConfigKey([Inventory::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            $inventory = $this->inventoryRepository->update($attributes, $id);

            $this->setAttributes($inventory, data_get($attributes, ['variants', 'attribute'], []));
            $this->syncProductCombos($inventory, data_get($attributes, 'product_combos', []));

            return $inventory;
        });
    }

    public function syncProductCombos(Inventory $inventory, array $productCombos = [])
    {
        DB::table('product_combo_inventories')->where('inventory_id', $inventory->getKey())->delete();

        $data = [];

        foreach ($productCombos as $combo) {
            $data[] = [
                'product_combo_id' => data_get($combo, 'product_combo_id'),
                'inventory_id' => $inventory->getKey(),
                'quantity' => data_get($combo, 'quantity'),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('product_combo_inventories')->insert($data);
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

    public function searchVariantsByProductForGuest($productId)
    {
        $inventories = $this->inventoryRepository
            ->modelScopes(['active', 'feDisplay'])
            ->with(['attributeValues:id', 'attributes:id'])
            ->scopeQuery(function($q) use ($productId) {
                $q->where('product_id', BaseModel::getModelKey($productId));
            })
            ->all(['id', 'slug']);

        return $inventories;
    }

    public function showBySlugForGuest($slug)
    {
        $inventory = $this->inventoryRepository
            ->modelScopes(['feDisplay', 'active'])
            ->with(['product', 'attributeValues', 'attributes', 'productCombos'])
            ->scopeQuery(function($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->first([
                'available_from',
                'condition',
                'condition_note',
                'id',
                'image',
                'key_features',
                'meta_description',
                'meta_title',
                'min_order_quantity',
                'offer_end',
                'offer_price',
                'offer_start',
                'product_id',
                'sale_price',
                'sku',
                'slug',
                'stock_quantity',
                'title',
            ]);

        return $inventory;
    }
}
