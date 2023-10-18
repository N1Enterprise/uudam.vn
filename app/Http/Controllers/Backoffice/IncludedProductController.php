<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreIncludedProductRequestContract;
use App\Contracts\Requests\Backoffice\UpdateIncludedProductRequestContract;
use App\Contracts\Responses\Backoffice\DeleteIncludedProductResponseContract;
use App\Contracts\Responses\Backoffice\StoreIncludedProductResponseContract;
use App\Contracts\Responses\Backoffice\UpdateIncludedProductResponseContract;
use App\Services\IncludedProductService;

class IncludedProductController extends BaseController
{
    public $includedProductService;

    public function __construct(IncludedProductService $includedProductService)
    {
        $this->includedProductService = $includedProductService;
    }

    public function index()
    {
        return view('backoffice.pages.included-products.index');
    }

    public function create()
    {
        return view('backoffice.pages.included-products.create');
    }

    public function edit($id)
    {
        $includedProduct = $this->includedProductService->show($id);

        return view('backoffice.pages.included-products.edit', compact('includedProduct'));
    }

    public function store(StoreIncludedProductRequestContract $request)
    {
        $includedProduct = $this->includedProductService->create($request->validated());

        return $this->response(StoreIncludedProductResponseContract::class, $includedProduct);
    }

    public function update(UpdateIncludedProductRequestContract $request, $id)
    {
        $includedProduct = $this->includedProductService->update($request->validated(), $id);

        return $this->response(UpdateIncludedProductResponseContract::class, $includedProduct);
    }

    public function destroy($id)
    {
        $status = $this->includedProductService->delete($id);

        return $this->response(DeleteIncludedProductResponseContract::class, ['status' => $status]);
    }
}
