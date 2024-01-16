<?php

namespace App\Http\Controllers\Frontend;

use App\Services\AddressService;
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
        dd($code);
    }
}
