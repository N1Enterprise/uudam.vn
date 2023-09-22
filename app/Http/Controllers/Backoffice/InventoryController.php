<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreInventoryRequestContract;
use App\Contracts\Requests\Backoffice\UpdateInventoryRequestContract;
use App\Contracts\Responses\Backoffice\DeleteInventoryResponseContract;
use App\Contracts\Responses\Backoffice\StoreInventoryResponseContract;
use App\Contracts\Responses\Backoffice\UpdateInventoryResponseContract;
use App\Enum\InventoryConditionEnum;
use App\Enum\ProductTypeEnum;
use App\Services\AttributeService;
use App\Services\CategoryService;
use App\Services\InventoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class InventoryController extends BaseController
{
    public $inventoryService;
    public $categoryService;
    public $productService;
    public $attributeService;

    public function __construct(
        InventoryService $inventoryService,
        CategoryService $categoryService,
        ProductService $productService,
        AttributeService $attributeService
    ) {
        $this->inventoryService = $inventoryService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $categories = $this->categoryService
            ->allAvailable(['with' => 'products', 'columns' => ['id', 'name']])
            ->filter(fn($category) => !$category->products->isEmpty());

        $attributes = $this->attributeService
            ->allAvailable(['with' => 'attributeValues', 'columns' => ['id', 'name']])
            ->filter(fn($attribute) => !$attribute->attributeValues->isEmpty());

        return view('backoffice.pages.inventories.index', compact('categories', 'attributes'));
    }

    public function create(Request $request)
    {
        $variants = $this->attributeService->confirmAttributes($request->input('attribute_values'));
        $attributes = $this->attributeService->allAvailable(['columns' => ['id', 'name']])->pluck('name', 'id');
        $product = $this->productService->show($request->input('product_id'));
        $inventoryConditionEnumLabels = InventoryConditionEnum::labels();
        $combinations = generate_combinations($variants);

        return view('backoffice.pages.inventories.create', compact('attributes', 'product', 'combinations', 'inventoryConditionEnumLabels'));
    }

    public function edit($id)
    {
        $inventory = $this->inventoryService->show($id);

        return view('backoffice.pages.inventories.edit', compact('inventory', 'inventory'));
    }

    public function store(StoreInventoryRequestContract $request)
    {
        dd($request->validated());
        $product = $this->productService->show($request->product_id);
        dd($product);

        if ($product->type == ProductTypeEnum::VARIABLE) {
            $inventory = $this->inventoryService->createWithVariants($request->validated());
        }

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
