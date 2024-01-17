<?php

namespace App\Http\Controllers\Frontend;

use App\Services\AddressService;
use App\Vendors\Localization\District;
use App\Vendors\Localization\Province;
use App\Vendors\Localization\Ward;
use Illuminate\Http\Request;

class UserAddressController extends AuthenticatedController
{
    public $addressService;

    public function __construct(AddressService $addressService)
    {
        parent::__construct();

        $this->addressService = $addressService;
    }

    public function address()
    {
        $addresses = $this->addressService->listByUser($this->user());

        return $this->view('frontend.pages.profile.address.index', compact('addresses'));
    }

    public function edit(Request $request, $code)
    {
        $address   = $this->addressService->findByUserAndCode($this->user(), $code);
        $provinces = Province::make()->all();
        $districts = District::make()->getByProviceCode(data_get($address, 'province_code'));
        $wards     = Ward::make()->getByDistrictCode(data_get($address, 'district_code')); 

        return $this->view('frontend.pages.profile.address.edit', compact('address', 'provinces', 'districts', 'wards'));
    }

    public function create(Request $request)
    {
        return $this->view('frontend.pages.profile.address.create');
    }
}
