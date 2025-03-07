<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreProductRequestContract;
use App\Contracts\Requests\Backoffice\UpdateProductRequestContract;
use App\Contracts\Responses\Backoffice\StoreProductResponseContract;
use App\Contracts\Responses\Backoffice\UpdateProductResponseContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\ProductTypeEnum;
use App\Services\CategoryGroupService;
use App\Services\CategoryService;
use App\Services\InventoryService;
use App\Services\PostCategoryService;
use App\Services\ProductService;

class ProductController extends BaseController
{
    public $productService;
    public $categoryService;
    public $inventoryService;
    public $postCategoryService;
    public $categoryGroupService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        InventoryService $inventoryService,
        PostCategoryService $postCategoryService,
        CategoryGroupService $categoryGroupService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->inventoryService = $inventoryService;
        $this->postCategoryService = $postCategoryService;
        $this->categoryGroupService = $categoryGroupService;
    }

    public function index()
    {
        $categoryGroups = $this->categoryGroupService->allAvailable(['with' => 'categories']);
        $statusLabels = ActivationStatusEnum::labels();
        $productTypeLabels = ProductTypeEnum::labels();

        return view('backoffice.pages.products.index', compact('categoryGroups', 'statusLabels', 'productTypeLabels'));
    }

    public function create()
    {
        $productTypeLabels = ProductTypeEnum::labels();
        $categoryGroups = $this->categoryGroupService->allAvailable(['with' => 'categories']);
        $relatedInventories = $this->inventoryService->allAvailableForGuest(['columns' => ['id', 'title']]);

        $categoryRelatedPosts = $this->postCategoryService
            ->allAvailable(['with' => ['posts'], 'columns' => ['id', 'name']])
            ->filter(fn($category) => !$category->posts->isEmpty());

        return view('backoffice.pages.products.create', compact(
            'categoryGroups',
            'productTypeLabels',
            'relatedInventories',
            'categoryRelatedPosts',
        ));
    }

    public function edit($id)
    {
        $product = $this->productService->show($id, ['with' => 'categories', 'linkedPosts']);
        $productTypeLabels = ProductTypeEnum::labels();
        $categoryGroups = $this->categoryGroupService->allAvailable(['with' => 'categories']);

        $relatedInventories = $this->inventoryService->allAvailableForGuest();

        $categoryRelatedPosts = $this->postCategoryService
            ->allAvailable(['with' => ['posts']])
            ->filter(fn($category) => !$category->posts->isEmpty());

        return view('backoffice.pages.products.edit', compact('product', 'productTypeLabels', 'categoryGroups', 'relatedInventories', 'categoryRelatedPosts'));
    }

    public function store(StoreProductRequestContract $request)
    {
        $product = $this->productService->create($request->validated());

        return $this->response(StoreProductResponseContract::class, $product);
    }

    public function update(UpdateProductRequestContract $request, $id)
    {
        $product = $this->productService->update($request->validated(), $id);

        return $this->response(UpdateProductResponseContract::class, $product);
    }
}
