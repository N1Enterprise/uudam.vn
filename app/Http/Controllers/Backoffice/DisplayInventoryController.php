<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreDisplayInventoryRequestContract;
use App\Contracts\Requests\Backoffice\UpdateDisplayInventoryRequestContract;
use App\Contracts\Responses\Backoffice\DeleteDisplayInventoryResponseContract;
use App\Contracts\Responses\Backoffice\StoreDisplayInventoryResponseContract;
use App\Contracts\Responses\Backoffice\UpdateDisplayInventoryResponseContract;
use App\Enum\DisplayInventoryTypeEnum;
use App\Services\DisplayInventoryService;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class DisplayInventoryController extends BaseController
{
    public $displayInventoryService;
    public $inventoryService;

    public function __construct(DisplayInventoryService $displayInventoryService, InventoryService $inventoryService)
    {
        $this->displayInventoryService = $displayInventoryService;
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        $inventories = $this->inventoryService->allAvailable();

        $displayInventoryTypeEnumLabels = DisplayInventoryTypeEnum::labels();

        return view('backoffice.pages.display-inventories.index', compact('inventories', 'displayInventoryTypeEnumLabels'));
    }

    public function create(Request $request, $type)
    {
        $inventories = $this->inventoryService
            ->allAvailable()
            ->filter(function($item) use ($type) {
                return !in_array(
                    data_get($item, 'id'),
                    $this->displayInventoryService
                        ->allAvailableByType($type, ['columns' => 'inventory_id'])
                        ->pluck('inventory_id')
                        ->toArray()
                );
            });

        $displayInventoryTypeEnumLabels = DisplayInventoryTypeEnum::labels();

        return view('backoffice.pages.display-inventories.create', compact('type', 'inventories', 'displayInventoryTypeEnumLabels'));
    }

    public function edit($id, $type)
    {
        $displayInventory = $this->displayInventoryService->show($id);

        $inventories = $this->inventoryService
            ->allAvailable()
            ->filter(function($item) use ($type, $displayInventory) {
                return data_get($item, 'id') == data_get($displayInventory, 'inventory_id')
                    || !in_array(
                        data_get($item, 'id'),
                        $this->displayInventoryService
                            ->allAvailableByType($type, ['columns' => 'inventory_id'])
                            ->pluck('inventory_id')
                            ->toArray()
                        );
            });

        $displayInventoryTypeEnumLabels = DisplayInventoryTypeEnum::labels();

        return view('backoffice.pages.display-inventories.edit', compact('inventories', 'displayInventoryTypeEnumLabels', 'displayInventory', 'type'));
    }

    public function store(StoreDisplayInventoryRequestContract $request)
    {
        $displayInventory = $this->displayInventoryService->create($request->validated());

        return $this->response(StoreDisplayInventoryResponseContract::class, $displayInventory);
    }

    public function update(UpdateDisplayInventoryRequestContract $request, $id)
    {
        $displayInventory = $this->displayInventoryService->update($request->validated(), $id);

        return $this->response(UpdateDisplayInventoryResponseContract::class, $displayInventory);
    }

    public function destroy($id)
    {
        $status = $this->displayInventoryService->delete($id);

        return $this->response(DeleteDisplayInventoryResponseContract::class, ['status' => $status]);
    }
}
