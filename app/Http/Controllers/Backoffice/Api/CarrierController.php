<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListCarrierResponseContract;
use App\Services\CarrierService;
use Illuminate\Http\Request;

class CarrierController extends BaseApiController
{
    public $carrierService;

    public function __construct(CarrierService $carrierService)
    {
        $this->carrierService = $carrierService;
    }

    public function index(Request $request)
    {
        $carriers = $this->carrierService->searchByAdmin($request->all());

        return $this->response(ListCarrierResponseContract::class, $carriers);
    }
}
