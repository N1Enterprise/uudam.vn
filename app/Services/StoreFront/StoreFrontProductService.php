<?php

namespace App\Services\StoreFront;

use App\Services\BaseService;
use App\Services\InventoryService;

class StoreFrontProductService extends BaseService
{
    public $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function findInventoryBySlug($slug)
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
            }
        ]);

        return $inventory;
    }
}
