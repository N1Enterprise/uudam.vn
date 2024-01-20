<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreShippingProviderRequestContract;
use App\Contracts\Requests\Backoffice\UpdateShippingProviderRequestContract;
use App\Contracts\Responses\Backoffice\StoreShippingProviderResponseContract;
use App\Contracts\Responses\Backoffice\UpdateShippingProviderResponseContract;
use App\Shipping\ShippingIntegrationService;
use App\Services\ShippingProviderService;
use App\Services\ShippingZoneService;
use App\Vendors\Localization\Country;
use App\Vendors\Localization\Province;

class ShippingProviderController extends BaseController
{
    public $shippingProviderService;
    public $shippingZoneService;

    public function __construct(ShippingProviderService $shippingProviderService, ShippingZoneService $shippingZoneService)
    {
        $this->shippingProviderService = $shippingProviderService;
        $this->shippingZoneService = $shippingZoneService;
    }

    public function index()
    {
        return view('backoffice.pages.shipping-providers.index');
    }

    public function create()
    {
        $providers = ShippingIntegrationService::availableProviders();
        $countries = Country::make()->all();
        $provinces = Province::make()->all();

        return view('backoffice.pages.shipping-providers.create', compact('providers', 'countries', 'provinces'));
    }

    public function edit($id)
    {
        $shippingProvider = $this->shippingProviderService->show($id);
        $providers = ShippingIntegrationService::availableProviders();
        $countries = Country::make()->all();
        $provinces = Province::make()->all();

        return view('backoffice.pages.shipping-providers.edit', compact('shippingProvider', 'providers', 'countries', 'provinces'));
    }

    public function store(StoreShippingProviderRequestContract $request)
    {
        $shippingProvider = $this->shippingProviderService->create($request->validated());

        return $this->response(StoreShippingProviderResponseContract::class, $shippingProvider);
    }

    public function update(UpdateShippingProviderRequestContract $request, $id)
    {
        $shippingProvider = $this->shippingProviderService->update($request->validated(), $id);

        return $this->response(UpdateShippingProviderResponseContract::class, $shippingProvider);
    }
}
