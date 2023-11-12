<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListProductComboResponseContract;
use App\Services\ProductComboService;
use Illuminate\Http\Request;

class ProductComboController extends BaseApiController
{
    public $productComboService;

    public function __construct(ProductComboService $productComboService)
    {
        $this->productComboService = $productComboService;
    }

    public function index(Request $request)
    {
        $productCombos = $this->productComboService->searchByAdmin($request->all());

        return $this->response(ListProductComboResponseContract::class, $productCombos);
    }
}
