<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListShippingZoneResponseContract;
use App\Services\ShippingZoneService;
use Illuminate\Http\Request;

class ShippingZoneController extends BaseApiController
{
    public $shippingZoneService;

    public function __construct(ShippingZoneService $shippingZoneService)
    {
        $this->shippingZoneService = $shippingZoneService;
    }

    public function index(Request $request)
    {
        $shippingZones = $this->shippingZoneService->searchByAdmin($request->all());

        return $this->response(ListShippingZoneResponseContract::class, $shippingZones);
    }
}
