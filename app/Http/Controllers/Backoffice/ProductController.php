<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreProductRequestContract;
use App\Contracts\Requests\Backoffice\UpdateProductRequestContract;
use App\Contracts\Responses\Backoffice\StoreProductResponseContract;
use App\Contracts\Responses\Backoffice\UpdateProductResponseContract;
use App\Enum\ProductTypeEnum;
use App\Services\CategoryGroupService;
use App\Services\ProductService;

class ProductController extends BaseController
{
    public $productService;
    public $categoryGroupService;

    public function __construct(ProductService $productService, CategoryGroupService $categoryGroupService)
    {
        $this->productService = $productService;
        $this->categoryGroupService = $categoryGroupService;
    }

    public function index()
    {
        return view('backoffice.pages.products.index');
    }

    public function create()
    {
        $productTypeLabels = ProductTypeEnum::labels();
        $categoryGroups = $this->categoryGroupService->allAvailable(['with' => 'categories']);

        return view('backoffice.pages.products.create', compact('productTypeLabels', 'categoryGroups'));
    }

    public function edit($id)
    {
        $product = $this->productService->show($id, ['with' => 'categories']);
        $productTypeLabels = ProductTypeEnum::labels();
        $categoryGroups = $this->categoryGroupService->allAvailable(['with' => 'categories']);

        return view('backoffice.pages.products.edit', compact('product', 'productTypeLabels', 'categoryGroups'));
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
