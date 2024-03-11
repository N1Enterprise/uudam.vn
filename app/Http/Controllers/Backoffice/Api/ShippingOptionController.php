<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListAvailableShippingOptionResponseContract;
use App\Contracts\Responses\Backoffice\ListShippingOptionResponseContract;
use App\Services\ShippingOptionService;
use Illuminate\Http\Request;

class ShippingOptionController extends BaseApiController
{
    public $shippingOptionService;

    public function __construct(ShippingOptionService $shippingOptionService)
    {
        $this->shippingOptionService = $shippingOptionService;
    }

    public function index(Request $request)
    {
        $shippingOptions = $this->shippingOptionService->searchByAdmin($request->all());

        return $this->response(ListShippingOptionResponseContract::class, $shippingOptions);
    }

    public function getAvailable(Request $request)
    {
        $shippingOptions = $this->shippingOptionService->allAvailable($request->all());

        return $this->response(ListAvailableShippingOptionResponseContract::class, $shippingOptions);
    }
}
