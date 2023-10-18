<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListIncludedProductResponseContract;
use App\Services\IncludedProductService;
use Illuminate\Http\Request;

class IncludedProductController extends BaseApiController
{
    public $includedProductService;

    public function __construct(IncludedProductService $includedProductService)
    {
        $this->includedProductService = $includedProductService;
    }

    public function index(Request $request)
    {
        $includedProducts = $this->includedProductService->searchByAdmin($request->all());

        return $this->response(ListIncludedProductResponseContract::class, $includedProducts);
    }
}
