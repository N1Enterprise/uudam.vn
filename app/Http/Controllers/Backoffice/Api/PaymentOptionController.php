<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListPaymentOptionResponseContract;
use App\Services\PaymentOptionService;
use Illuminate\Http\Request;

class PaymentOptionController extends BaseApiController
{
    public $paymentOptionService;

    public function __construct(PaymentOptionService $paymentOptionService)
    {
        $this->paymentOptionService = $paymentOptionService;
    }

    public function index(Request $request)
    {
        $paymentOption = $this->paymentOptionService->searchByAdmin($request->all());

        return $this->response(ListPaymentOptionResponseContract::class, $paymentOption);
    }
}
