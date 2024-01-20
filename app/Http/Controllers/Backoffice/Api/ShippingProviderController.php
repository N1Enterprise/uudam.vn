<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListShippingProviderResponseContract;
use App\Services\ShippingProviderService;
use Illuminate\Http\Request;

class ShippingProviderController extends BaseApiController
{
    public $shippingProviderService;

    public function __construct(ShippingProviderService $shippingProviderService)
    {
        $this->shippingProviderService = $shippingProviderService;
    }

    public function index(Request $request)
    {
        $shippingProviders = $this->shippingProviderService->searchByAdmin($request->all());

        return $this->response(ListShippingProviderResponseContract::class, $shippingProviders);
    }
}
