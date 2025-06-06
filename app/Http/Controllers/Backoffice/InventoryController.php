<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreInventoryRequestContract;
use App\Contracts\Requests\Backoffice\UpdateInventoryRequestContract;
use App\Contracts\Responses\Backoffice\DeleteInventoryResponseContract;
use App\Contracts\Responses\Backoffice\StoreInventoryResponseContract;
use App\Contracts\Responses\Backoffice\UpdateInventoryResponseContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\InventoryConditionEnum;
use App\Enum\ProductTypeEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Models\Inventory;
use App\Models\SystemSetting;
use App\Services\AttributeService;
use App\Services\CategoryService;
use App\Services\ProductComboService;
use App\Services\InventoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class InventoryController extends BaseController
{
    public $inventoryService;
    public $categoryService;
    public $productService;
    public $attributeService;
    public $productComboService;

    public function __construct(
        InventoryService $inventoryService,
        CategoryService $categoryService,
        ProductService $productService,
        AttributeService $attributeService,
        ProductComboService $productComboService
    ) {
        $this->inventoryService = $inventoryService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->attributeService = $attributeService;
        $this->productComboService = $productComboService;
    }

    public function index()
    {
        $categories = $this->categoryService
            ->allAvailable(['with' => ['products', 'categoryGroup'], 'columns' => ['id', 'name', 'category_group_id']])
            ->filter(fn($category) => !$category->products->isEmpty());

        $attributes = $this->attributeService
            ->allAvailable(['with' => 'attributeValues', 'columns' => ['id', 'name', 'supported_categories', 'order']])
            ->sortBy('order')
            ->filter(fn($attribute) => !$attribute->attributeValues->isEmpty());

        $statusLabels = ActivationStatusEnum::labels();

        return view('backoffice.pages.inventories.index', compact('categories', 'attributes', 'statusLabels'));
    }

    public function create(Request $request)
    {
        $product = $this->productService->show($request->input('product_id'));
        $inventory = new Inventory();

        $attributes = [];
        $combinations = [];

        $hasVariant = $product->type == ProductTypeEnum::VARIABLE;

        if ($hasVariant) {
            $variants = $this->attributeService->confirmAttributes($request->input('attribute_values') ?? []);
            $attributes = $this->attributeService->allAvailable(['columns' => ['id', 'name']])->pluck('name', 'id');
            $combinations = generate_combinations($variants);
        }

        if (empty(array_filter($combinations))) {
            $hasVariant = false;
        }

        $inventoryConditionEnumLabels = InventoryConditionEnum::labels();

        $commonInventoryKeyFeatured = collect(SystemSetting::from(SystemSettingKeyEnum::COMMON_INVENTORY_KEY_FEATURED)->get(null, []))->filter(fn($item) => boolean(data_get($item, 'enable')));

        $affiliateSalesChannels = SystemSetting::from(SystemSettingKeyEnum::AFFILIATE_SALES_CHANNELS)->get(null, []);

        return view('backoffice.pages.inventories.create', compact(
            'inventory',
            'product',
            'hasVariant',
            'attributes',
            'combinations',
            'inventoryConditionEnumLabels',
            'commonInventoryKeyFeatured',
            'affiliateSalesChannels'
        ));
    }

    public function edit($id)
    {
        $inventory = $this->inventoryService->show($id, ['with' => 'attributes', 'attributeValues', 'productCombos']);
        $product = $this->productService->show($inventory->product_id);

        $hasVariant = $product->type == ProductTypeEnum::VARIABLE;
        $attributes = [];
        $combinations = [];

        if ($hasVariant) {
            $attributes = $inventory->attributes;
            $attributeValues = $inventory->attributeValues;

            $attributeValues = collect($attributes)
                ->mapWithKeys(function($attribute) use ($attributeValues) {
                    return [
                        $attribute->id => $attributeValues
                            ->where('attribute_id', $attribute->id)
                            ->pluck('id')
                            ->toArray()
                    ];
                })
                ->toArray();

            $variants = $this->attributeService->confirmAttributes($attributeValues ?? []);
            $attributes = $this->attributeService->allAvailable(['columns' => ['id', 'name']])->pluck('name', 'id');
            $combinations = generate_combinations($variants);
        }

        $inventoryConditionEnumLabels = InventoryConditionEnum::labels();
        $productCombos = $this->productComboService->allAvailable(['columns' => ['id', 'name', 'unit', 'sale_price']]);

        $commonInventoryKeyFeatured = collect(SystemSetting::from(SystemSettingKeyEnum::COMMON_INVENTORY_KEY_FEATURED)->get(null, []))->filter(fn($item) => boolean(data_get($item, 'enable')));

        $affiliateSalesChannels = SystemSetting::from(SystemSettingKeyEnum::AFFILIATE_SALES_CHANNELS)->get(null, []);

        return view('backoffice.pages.inventories.create', compact(
            'inventory',
            'product',
            'hasVariant',
            'attributes',
            'combinations',
            'inventoryConditionEnumLabels',
            'productCombos',
            'commonInventoryKeyFeatured',
            'affiliateSalesChannels'
        ));
    }

    public function store(StoreInventoryRequestContract $request)
    {
        $product = $this->productService->show($request->product_id);

        if ($product->type == ProductTypeEnum::VARIABLE && boolean($request->hasvariant)) {
            $inventory = $this->inventoryService->createWithVariants($request->validated());
        } else {
            $inventory = $this->inventoryService->create($request->validated());
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
