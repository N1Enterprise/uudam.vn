<?php

namespace App\Services\StoreFront;

use App\Enum\ActivationStatusEnum;
use App\Services\BaseService;
use App\Services\DisplayInventoryService;
use App\Services\InventoryService;
use Illuminate\Support\Facades\DB;

class StoreFrontProductDisplayService extends BaseService
{
    public $displayInventoryService;
    public $inventoryService;

    public function __construct(DisplayInventoryService $displayInventoryService, InventoryService $inventoryService)
    {
        $this->displayInventoryService = $displayInventoryService;
        $this->inventoryService = $inventoryService;
    }

    public function allAvailableInventoryDisplayedByType($type)
    {
        $inventories = DB::table('inventories')
            ->select([
                'inventories.*',
                'products.primary_image as product_image',
                'products.branch as product_branch'
            ])
            ->where('inventories.status', ActivationStatusEnum::ACTIVE)
            ->leftJoin('products', 'products.id', '=', 'inventories.product_id')
            ->whereIn('inventories.id', DB::table('display_inventories')->where('status', ActivationStatusEnum::ACTIVE)->where('type', $type)->select('inventory_id'))
            ->get();

        return $inventories;
    }

    public function showBySlug($slug)
    {
        $inventory = $this->inventoryService->inventoryRepository
            ->modelScopes(['active'])
            ->scopeQuery(function($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->first();

        $inventory->load([
            'product' => function($q) use ($inventory) {
                $q->select(['id', 'code', 'branch', 'description', 'media', 'created_at'])
                    ->withCount('inventories');
            },
            'attributeValues' => function($q) {
                $q->select(['attribute_values.id', 'attribute_values.attribute_id', 'attribute_values.value', 'attribute_values.order'])
                    ->with('attribute:id,name,attribute_type,order');
            },
            'attributes' => function($q) {
                $q->select('attributes.id', 'attributes.name', 'attributes.attribute_type', 'attributes.order');
            }
        ]);

        return $inventory;
    }
}
