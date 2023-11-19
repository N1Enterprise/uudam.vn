<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreShippingRateRequestContract;
use App\Contracts\Requests\Backoffice\UpdateShippingRateRequestContract;
use App\Contracts\Responses\Backoffice\DeleteShippingRateResponseContract;
use App\Contracts\Responses\Backoffice\StoreShippingRateResponseContract;
use App\Contracts\Responses\Backoffice\UpdateShippingRateResponseContract;
use App\Enum\ShippingRateTypeEnum;
use App\Services\CarrierService;
use App\Services\ShippingRateService;
use App\Services\ShippingZoneService;

class ShippingRateController extends BaseController
{
    public $shippingRateService;
    public $shippingZoneService;
    public $carrierService;

    public function __construct(
        ShippingRateService $shippingRateService,
        ShippingZoneService $shippingZoneService,
        CarrierService $carrierService
    ) {
        $this->shippingRateService = $shippingRateService;
        $this->shippingZoneService = $shippingZoneService;
        $this->carrierService = $carrierService;
    }

    public function index()
    {
        $shippingZones = $this->shippingZoneService->allAvailable(['columns' => ['id', 'name']]);
        $carriers = $this->carrierService->allAvailable(['columns' => ['id', 'name']]);
        $shippingRateTypeEnumLabels = ShippingRateTypeEnum::labels();

        return view('backoffice.pages.shipping-rates.index', compact('shippingZones', 'carriers', 'shippingRateTypeEnumLabels'));
    }

    public function create()
    {
        $shippingZones = $this->shippingZoneService->allAvailable(['columns' => ['id', 'name']]);
        $carriers = $this->carrierService->allAvailable(['columns' => ['id', 'name']]);
        $shippingRateTypeEnumLabels = ShippingRateTypeEnum::labels();

        return view('backoffice.pages.shipping-rates.create', compact('shippingZones', 'carriers', 'shippingRateTypeEnumLabels'));
    }

    public function edit($id)
    {
        $shippingRate = $this->shippingRateService->show($id);
        $shippingZones = $this->shippingZoneService->allAvailable(['columns' => ['id', 'name']]);
        $carriers = $this->carrierService->allAvailable(['columns' => ['id', 'name']]);
        $shippingRateTypeEnumLabels = ShippingRateTypeEnum::labels();

        return view('backoffice.pages.shipping-rates.edit', compact('shippingRate', 'shippingZones', 'carriers', 'shippingRateTypeEnumLabels'));
    }

    public function store(StoreShippingRateRequestContract $request)
    {
        $shippingRate = $this->shippingRateService->create($request->validated());

        return $this->response(StoreShippingRateResponseContract::class, $shippingRate);
    }

    public function update(UpdateShippingRateRequestContract $request, $id)
    {
        $shippingRate = $this->shippingRateService->update($request->validated(), $id);

        return $this->response(UpdateShippingRateResponseContract::class, $shippingRate);
    }

    public function destroy($id)
    {
        $status = $this->shippingRateService->delete($id);

        return $this->response(DeleteShippingRateResponseContract::class, ['status' => $status]);
    }
}
