<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreShippingOptionRequestContract;
use App\Contracts\Requests\Backoffice\UpdateShippingOptionRequestContract;
use App\Contracts\Responses\Backoffice\StoreShippingOptionResponseContract;
use App\Contracts\Responses\Backoffice\UpdateShippingOptionResponseContract;
use App\Enum\ShippingOptionTypeEnum;
use App\Services\ShippingOptionService;
use App\Services\ShippingProviderService;
use App\Vendors\Localization\Country;
use App\Vendors\Localization\Province;

class ShippingOptionController extends BaseController
{
    public $shippingOptionService;
    public $shippingProviderService;

    public function __construct(ShippingOptionService $shippingOptionService, ShippingProviderService $shippingProviderService)
    {
        $this->shippingOptionService = $shippingOptionService;
        $this->shippingProviderService = $shippingProviderService;
    }

    public function index()
    {
        return view('backoffice.pages.shipping-options.index');
    }

    public function create()
    {
        $shippingOptionTypeEnumLabels = ShippingOptionTypeEnum::labels();
        $shippingProviders = $this->shippingProviderService->allAvailable();
        $countries = Country::make()->all();
        $provinces = Province::make()->all();

        return view('backoffice.pages.shipping-options.create', compact(
            'shippingOptionTypeEnumLabels', 
            'shippingProviders',
            'countries', 
            'provinces'
        ));
    }

    public function edit($id)
    {
        $shippingOption = $this->shippingOptionService->show($id);
        $shippingOptionTypeEnumLabels = ShippingOptionTypeEnum::labels();
        $shippingProviders = $this->shippingProviderService->allAvailable();
        $countries = Country::make()->all();
        $provinces = Province::make()->all();

        return view('backoffice.pages.shipping-options.edit', compact(
            'shippingOption',
            'shippingOptionTypeEnumLabels',
            'shippingProviders',
            'countries',
            'provinces'
        ));
    }

    public function store(StoreShippingOptionRequestContract $request)
    {
        $shippingOption = $this->shippingOptionService->create($request->validated());

        return $this->response(StoreShippingOptionResponseContract::class, $shippingOption);
    }

    public function update(UpdateShippingOptionRequestContract $request, $id)
    {
        $shippingOption = $this->shippingOptionService->update($request->validated(), $id);

        return $this->response(UpdateShippingOptionResponseContract::class, $shippingOption);
    }
}
