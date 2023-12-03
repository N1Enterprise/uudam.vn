<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListCountryResponseContract;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends BaseApiController
{
    public $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        $countries = $this->countryService->searchByAdmin($request->all());

        return $this->response(ListCountryResponseContract::class, $countries);
    }
}
