<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Requests\Backoffice\DeclineDepositTransactionRequestContract;
use App\Contracts\Responses\Backoffice\ListDepositTransactionResponseContract;
use App\Services\DepositService;
use App\Services\DepositTransactionService;
use Illuminate\Http\Request;

class DepositTransactionController extends BaseApiController
{
    public $depositTransactionService;
    public $depositService;

    public function __construct(DepositTransactionService $depositTransactionService, DepositService $depositService)
    {
        $this->depositTransactionService = $depositTransactionService;
        $this->depositService = $depositService;
    }

    public function index(Request $request)
    {
        $transactions = $this->depositTransactionService->searchByAdmin($request->all());

        return $this->response(ListDepositTransactionResponseContract::class, $transactions);
    }

    public function statisticStatus(Request $request, $status)
    {
        $count = $this->depositTransactionService->statisticStatus($status, $request->all());

        return response()->json(['count' => $count]);
    }

    public function statisticAmount(Request $request)
    {
        $total = $this->depositTransactionService->getTotalDepositAmount($request->all());

        return response($total ?? []);
    }

    public function decline(DeclineDepositTransactionRequestContract $request, $id)
    {
        $this->depositService->decline($id, $request->validated());

        return response()->json(['success' => true]);
    }
}
