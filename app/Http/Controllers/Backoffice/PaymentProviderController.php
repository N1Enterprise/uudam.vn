<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StorePaymentProviderRequestContract;
use App\Contracts\Requests\Backoffice\UpdatePaymentProviderRequestContract;
use App\Contracts\Responses\Backoffice\StorePaymentProviderResponseContract;
use App\Contracts\Responses\Backoffice\UpdatePaymentProviderResponseContract;
use App\Enum\PaymentTypeEnum;
use App\Payment\PaymentIntegrationService;
use App\Services\PaymentProviderService;
use App\Vendors\Localization\Country;

class PaymentProviderController extends BaseController
{
    public $paymentProviderService;

    public function __construct(PaymentProviderService $paymentProviderService)
    {
        $this->paymentProviderService = $paymentProviderService;
    }

    public function index()
    {
        return view('backoffice.pages.payment-providers.index');
    }

    public function create()
    {
        $countries = Country::make()->all();
        $providers = PaymentIntegrationService::availableProviders();
        $paymentTypeEnumLabels = PaymentTypeEnum::labels();

        return view('backoffice.pages.payment-providers.create', compact('countries', 'providers', 'paymentTypeEnumLabels'));
    }

    public function edit($id)
    {
        $paymentProvider = $this->paymentProviderService->show($id);
        $countries = Country::make()->all();
        $providers = PaymentIntegrationService::availableProviders();
        $paymentTypeEnumLabels = PaymentTypeEnum::labels();

        return view('backoffice.pages.payment-providers.edit', compact('paymentProvider', 'countries', 'providers', 'paymentTypeEnumLabels'));
    }

    public function store(StorePaymentProviderRequestContract $request)
    {
        $paymentProvider = $this->paymentProviderService->create($request->validated());

        return $this->response(StorePaymentProviderResponseContract::class, $paymentProvider);
    }

    public function update(UpdatePaymentProviderRequestContract $request, $id)
    {
        $paymentProvider = $this->paymentProviderService->update($request->validated(), $id);

        return $this->response(UpdatePaymentProviderResponseContract::class, $paymentProvider);
    }
}
