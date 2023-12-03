<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListSystemCurrencyResponseContract;
use App\Services\SystemCurrencyService;
use Illuminate\Http\Request;

class SystemCurrencyController extends BaseApiController
{
    public $systemCurrencyService;

    public function __construct(SystemCurrencyService $systemCurrencyService)
    {
        $this->systemCurrencyService = $systemCurrencyService;
    }

    public function index(Request $request)
    {
        $systemCurrencies = $this->systemCurrencyService->searchByAdmin($request->all());

        return $this->response(ListSystemCurrencyResponseContract::class, $systemCurrencies);
    }

    public function markAsDefault(Request $request, $key)
    {
        $this->systemCurrencyService->markAsDefault($key);

        return $this->responseNoContent();
    }

    public function markAsBase(Request $request, $key)
    {
        $this->systemCurrencyService->markAsBase($key);

        return $this->responseNoContent();
    }
}
