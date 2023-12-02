<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListCurrencyResponseContract;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends BaseApiController
{
    public $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index(Request $request)
    {
        $currencies = $this->currencyService->searchByAdmin($request->all());

        return $this->response(ListCurrencyResponseContract::class, $currencies);
    }
}
