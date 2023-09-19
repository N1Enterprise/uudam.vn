<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreInventoryRequestContract;
use App\Contracts\Requests\Backoffice\UpdateInventoryRequestContract;
use App\Contracts\Responses\Backoffice\DeleteInventoryResponseContract;
use App\Contracts\Responses\Backoffice\StoreInventoryResponseContract;
use App\Contracts\Responses\Backoffice\UpdateInventoryResponseContract;
use App\Services\InventoryService;
use App\Services\ProductService;

class InventoryController extends BaseController
{
    public $inventoryService;
    public $productService;

    public function __construct(InventoryService $inventoryService, ProductService $productService)
    {
        $this->inventoryService = $inventoryService;
        $this->productService = $productService;
    }

    public function index()
    {
        // $products = $this->productService->allAvailable(['with' => 'categories']);

        // dd($products);
        return view('backoffice.pages.inventories.index');
    }

    public function create()
    {

        return view('backoffice.pages.inventories.create');
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
