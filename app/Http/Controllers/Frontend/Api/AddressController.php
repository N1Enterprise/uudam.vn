<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\StoreUserAddressRequestContract;
use App\Contracts\Responses\Frontend\StoreUserAddressResponseContract;
use App\Services\AddressService;
use App\Vendors\Localization\District;
use App\Vendors\Localization\Province;
use App\Vendors\Localization\Ward;

class AddressController extends BaseApiController
{
    public $addressService;

    public function __construct(AddressService $addressService)
    {
        parent::__construct();
        
        return $this->addressService = $addressService;
    }

    public function getProvinces()
    {
        $provinces = Province::make()->all();

        return response()->json([ 'data' => $provinces ]);
    }

    public function getDistrictsByProvince($proviceCode)
    {
        $districts = District::make()->getByProviceCode($proviceCode);

        return response()->json([ 'data' => $districts ]);
    }

    public function getWardsByDistrict($districtCode)
    {
        $wards = Ward::make()->getByDistrictCode($districtCode);

        return response()->json([ 'data' => $wards ]);
    }

    public function store(StoreUserAddressRequestContract $request)
    {
        $address = $this->addressService->createByUser($request->validated(), $this->user());

        return $this->response(StoreUserAddressResponseContract::class, $address);        
    }
}