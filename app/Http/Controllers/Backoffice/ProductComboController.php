<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreProductComboRequestContract;
use App\Contracts\Requests\Backoffice\UpdateProductComboRequestContract;
use App\Contracts\Responses\Backoffice\DeleteProductComboResponseContract;
use App\Contracts\Responses\Backoffice\StoreProductComboResponseContract;
use App\Contracts\Responses\Backoffice\UpdateProductComboResponseContract;
use App\Services\ProductComboService;

class ProductComboController extends BaseController
{
    public $productComboService;

    public function __construct(ProductComboService $productComboService)
    {
        $this->productComboService = $productComboService;
    }

    public function index()
    {
        return view('backoffice.pages.product-combos.index');
    }

    public function create()
    {
        return view('backoffice.pages.product-combos.create');
    }

    public function edit($id)
    {
        $productCombo = $this->productComboService->show($id);

        return view('backoffice.pages.product-combos.edit', compact('productCombo'));
    }

    public function store(StoreProductComboRequestContract $request)
    {
        $productCombo = $this->productComboService->create($request->validated());

        return $this->response(StoreProductComboResponseContract::class, $productCombo);
    }

    public function update(UpdateProductComboRequestContract $request, $id)
    {
        $productCombo = $this->productComboService->update($request->validated(), $id);

        return $this->response(UpdateProductComboResponseContract::class, $productCombo);
    }

    public function destroy($id)
    {
        $status = $this->productComboService->delete($id);

        return $this->response(DeleteProductComboResponseContract::class, ['status' => $status]);
    }
}
