<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\StoreUserAddressRequestContract;
use App\Contracts\Requests\Frontend\UpdateUserAddressRequestContract;
use App\Contracts\Responses\Frontend\StoreUserAddressResponseContract;
use App\Http\Responses\Frontend\ShowUserAddressResponse;
use App\Services\AddressService;
use App\Vendors\Localization\District;
use App\Vendors\Localization\Province;
use App\Vendors\Localization\Ward;
use Illuminate\Http\Request;

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
        $provinces = Province::make()->allInCache();

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

    public function update(UpdateUserAddressRequestContract $request, $code)
    {
        $address = $this->addressService->updateByUserAndCode($request->validated(), $this->user(), $code);

        return $this->response(ShowUserAddressResponse::class, $address);
    }

    public function show(Request $request, $code)
    {
        $address = $this->addressService->findByUserAndCode($this->user(), $code);

        return $this->response(ShowUserAddressResponse::class, $address);
    }

    public function markAsDefault(Request $request, $code)
    {
        $address = $this->addressService->markAsDefault($this->user(), $code);

        return $this->response(ShowUserAddressResponse::class, $address);
    }

    public function getAddressByLocation(Request $request)
    {
        $provinceName = $request->province_name;
        $districtName = $request->district_name;
        $wardName = $request->ward_name;

        $province = Province::make()
            ->allInCache()
            ->where('full_name_en', $provinceName)->first();

        $district = District::make()
            ->allInCache()
            ->where('full_name_en', $districtName)
            ->where('province_code', data_get($province, 'code'))
            ->first();

        $ward = Ward::make()
            ->allInCache()
            ->where('full_name_en', $wardName)
            ->where('district_code', data_get($district, 'code'))
            ->first();

        return [
            'province' => $province,
            'district' => $district,
            'ward' => $ward,
        ];
    }
}
