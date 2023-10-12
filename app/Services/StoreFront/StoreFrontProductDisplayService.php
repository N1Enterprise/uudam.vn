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
}
