<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListPaymentProviderResponseContract;
use App\Services\PaymentProviderService;
use Illuminate\Http\Request;

class PaymentProviderController extends BaseApiController
{
    public $paymentProviderService;

    public function __construct(PaymentProviderService $paymentProviderService)
    {
        $this->paymentProviderService = $paymentProviderService;
    }

    public function index(Request $request)
    {
        $paymentProvider = $this->paymentProviderService->searchByAdmin($request->all());

        return $this->response(ListPaymentProviderResponseContract::class, $paymentProvider);
    }
}
