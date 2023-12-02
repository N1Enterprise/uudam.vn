<?php

namespace App\Http\Controllers\Backoffice;

use App\Services\CurrencyService;

class CurrencyController extends BaseController
{
    public $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        return view('backoffice.pages.currencies.index');
    }
}
