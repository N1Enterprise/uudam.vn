<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StorePaymentOptionRequestContract;
use App\Contracts\Requests\Backoffice\UpdatePaymentOptionRequestContract;
use App\Contracts\Responses\Backoffice\StorePaymentOptionResponseContract;
use App\Contracts\Responses\Backoffice\UpdatePaymentOptionResponseContract;
use App\Enum\PaymentOptionTypeEnum;
use App\Enum\PaymentTypeEnum;
use App\Services\PaymentOptionService;
use App\Services\PaymentProviderService;
use App\Vendors\Localization\Country;

class PaymentOptionController extends BaseController
{
    public $paymentOptionService;
    public $paymentProviderService;

    public function __construct(PaymentOptionService $paymentOptionService, PaymentProviderService $paymentProviderService)
    {
        $this->paymentOptionService = $paymentOptionService;
        $this->paymentProviderService = $paymentProviderService;
    }

    public function index()
    {
        return view('backoffice.pages.payment-options.index');
    }

    public function create()
    {
        $paymentProviders = $this->paymentProviderService->getProviderByType(PaymentTypeEnum::DEPOSIT);
        $paymentOptionTypeEnumLabels = PaymentOptionTypeEnum::labels();
        $countries = Country::make()->all();

        return view('backoffice.pages.payment-options.create', compact('paymentProviders', 'paymentOptionTypeEnumLabels', 'countries'));
    }

    public function edit($id)
    {
        $paymentOption = $this->paymentOptionService->show($id);
        $paymentProviders = $this->paymentProviderService->getProviderByType(PaymentTypeEnum::DEPOSIT);
        $paymentOptionTypeEnumLabels = PaymentOptionTypeEnum::labels();
        $countries = Country::make()->all();

        return view('backoffice.pages.payment-options.edit', compact('paymentOption', 'paymentProviders', 'paymentOptionTypeEnumLabels', 'countries'));
    }

    public function store(StorePaymentOptionRequestContract $request)
    {
        $paymentOption = $this->paymentOptionService->create($request->validated());

        return $this->response(StorePaymentOptionResponseContract::class, $paymentOption);
    }

    public function update(UpdatePaymentOptionRequestContract $request, $id)
    {
        $paymentOption = $this->paymentOptionService->update($request->validated(), $id);

        return $this->response(UpdatePaymentOptionResponseContract::class, $paymentOption);
    }
}
