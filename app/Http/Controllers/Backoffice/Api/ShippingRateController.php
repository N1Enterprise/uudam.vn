<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListShippingRateResponseContract;
use App\Services\ShippingRateService;
use Illuminate\Http\Request;

class ShippingRateController extends BaseApiController
{
    public $shippingRateService;

    public function __construct(ShippingRateService $shippingRateService)
    {
        $this->shippingRateService = $shippingRateService;
    }

    public function index(Request $request)
    {
        $shippingRates = $this->shippingRateService->searchByAdmin($request->all());

        return $this->response(ListShippingRateResponseContract::class, $shippingRates);
    }
}
