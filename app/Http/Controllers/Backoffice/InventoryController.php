<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreInventoryRequestContract;
use App\Contracts\Requests\Backoffice\UpdateInventoryRequestContract;
use App\Contracts\Responses\Backoffice\DeleteInventoryResponseContract;
use App\Contracts\Responses\Backoffice\StoreInventoryResponseContract;
use App\Contracts\Responses\Backoffice\UpdateInventoryResponseContract;
use App\Services\InventoryService;

class InventoryController extends BaseController
{
    public $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        return view('backoffice.pages.inventories.index');
    }

    public function create()
    {
        $inventory = $this->attributeService->allAvailable();

        return view('backoffice.pages.inventories.create', compact('inventory'));
    }

    public function edit($id)
    {
        $inventory = $this->inventoryService->show($id);

        return view('backoffice.pages.inventories.edit', compact('inventory', 'inventory'));
    }

    public function store(StoreInventoryRequestContract $request)
    {
        $inventory = $this->inventoryService->create($request->validated());

        return $this->response(StoreInventoryResponseContract::class, $inventory);
    }

    public function update(UpdateInventoryRequestContract $request, $id)
    {
        $inventory = $this->inventoryService->update($request->validated(), $id);

        return $this->response(UpdateInventoryResponseContract::class, $inventory);
    }

    public function destroy($id)
    {
        $status = $this->inventoryService->delete($id);

        return $this->response(DeleteInventoryResponseContract::class, ['status' => $status]);
    }
}
