<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreShippingZoneRequestContract;
use App\Contracts\Requests\Backoffice\UpdateShippingZoneRequestContract;
use App\Contracts\Responses\Backoffice\StoreShippingZoneResponseContract;
use App\Contracts\Responses\Backoffice\UpdateShippingZoneResponseContract;
use App\Services\ShippingZoneService;
use App\Vendors\Localization\Country;
use App\Vendors\Localization\Province;

class ShippingZoneController extends BaseController
{
    public $shippingZoneService;

    public function __construct(ShippingZoneService $shippingZoneService)
    {
        $this->shippingZoneService = $shippingZoneService;
    }

    public function index()
    {
        return view('backoffice.pages.shipping-zones.index');
    }

    public function create()
    {
        $countries = Country::make()->all();

        return view('backoffice.pages.shipping-zones.create', compact('countries'));
    }

    public function edit($id)
    {
        $shippingZone = $this->shippingZoneService->show($id);
        $countries = Country::make()->all();
        $provinces = Province::make()->all();

        return view('backoffice.pages.shipping-zones.edit', compact('shippingZone', 'countries', 'provinces'));
    }

    public function store(StoreShippingZoneRequestContract $request)
    {
        $shippingZone = $this->shippingZoneService->create($request->validated());

        return $this->response(StoreShippingZoneResponseContract::class, $shippingZone);
    }

    public function update(UpdateShippingZoneRequestContract $request, $id)
    {
        $shippingZone = $this->shippingZoneService->update($request->validated(), $id);

        return $this->response(UpdateShippingZoneResponseContract::class, $shippingZone);
    }
}
