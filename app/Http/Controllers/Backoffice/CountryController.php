<?php

namespace App\Http\Controllers\Backoffice;

use App\Services\CountryService;

class CountryController extends BaseController
{
    public $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        return view('backoffice.pages.countries.index');
    }
}
