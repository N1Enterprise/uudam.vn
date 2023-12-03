<?php

namespace App\Http\Controllers\Backoffice;

use App\Enum\DepositStatusEnum;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Services\DepositTransactionService;
use App\Services\PaymentOptionService;
use Illuminate\Http\Request;

class DepositTransactionController extends BaseController
{
    public $depositTransactionService;
    public $paymentOptionService;

    public function __construct(DepositTransactionService $depositTransactionService, PaymentOptionService $paymentOptionService)
    {
        $this->depositTransactionService = $depositTransactionService;
        $this->paymentOptionService = $paymentOptionService;
    }

    public function index()
    {
        $paymentOptions = $this->paymentOptionService->depositPaymentOptions();
        $depositStatusEnumLabels = DepositStatusEnum::labels();
        $orderStatusEnumLabels = OrderStatusEnum::labels();
        $paymentStatusEnumLabels = PaymentStatusEnum::labels();

        return view('backoffice.pages.deposit-transactions.index', compact(
            'paymentOptions',
            'depositStatusEnumLabels',
            'orderStatusEnumLabels',
            'paymentStatusEnumLabels'
        ));
    }

    public function edit(Request $request, $id)
    {
        $transaction = $this->depositTransactionService->show($id);

        return view('backoffice.pages.deposit-transactions.edit', compact('transaction'));
    }
}
