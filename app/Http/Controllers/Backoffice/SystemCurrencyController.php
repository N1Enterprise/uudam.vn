<?php

namespace App\Http\Controllers\Backoffice;

use App\Vendors\Localization\Currency;
use Illuminate\Http\Request;
use App\Contracts\Requests\Backoffice\StoreSystemCurrencyRequestContract;
use App\Contracts\Requests\Backoffice\UpdateSystemCurrencyRequestContract;
use App\Contracts\Responses\Backoffice\StoreSystemCurrencyResponseContract;
use App\Contracts\Responses\Backoffice\UpdateSystemCurrencyResponseContract;
use App\Services\SystemCurrencyService;

class SystemCurrencyController extends BaseController
{
    protected $systemCurrencyService;

    public function __construct(SystemCurrencyService $systemCurrencyService)
    {
        $this->systemCurrencyService = $systemCurrencyService;
    }

    public function index(Request $request)
    {
        return $this->view('backoffice.pages.system-currencies.index');
    }

    public function create(Request $request)
    {
        $currencies = Currency::make()->all([
            'group_by_type_name' => true
        ]);

        return $this->view('backoffice.pages.system-currencies.create', compact('currencies'));
    }

    public function store(StoreSystemCurrencyRequestContract $request)
    {
        $systemCurrency = $this->systemCurrencyService->create($request->validated());

        return $this->response(StoreSystemCurrencyResponseContract::class, $systemCurrency);
    }

    public function edit(Request $request, $key)
    {
        $systemCurrency = $this->systemCurrencyService->show($key);

        $currencies = Currency::make()->all([
            'group_by_type_name' => true
        ]);

        return $this->view('backoffice.pages.system-currencies.edit', compact('systemCurrency', 'currencies'));
    }

    public function update(UpdateSystemCurrencyRequestContract $request, $key)
    {
        $systemCurrency = $this->systemCurrencyService->update($key, $request->validated());

        return $this->response(UpdateSystemCurrencyResponseContract::class, $systemCurrency);
    }
}
