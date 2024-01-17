<?php

namespace App\Http\Controllers\Frontend;

use App\Services\AddressService;
use App\Services\UserService;

class UserProfileController extends AuthenticatedController
{
    public $userService;
    public $orderService;
    public $addressService;

    public function __construct(UserService $userService, AddressService $addressService)
    {
        parent::__construct();

        $this->userService = $userService;
        $this->addressService = $addressService;
    }

    public function account()
    {
        $user = $this->user();

        return $this->view('frontend.pages.profile.account.index', compact('user'));
    }

    public function passwordChange()
    {
        return $this->view('frontend.pages.profile.password-change.index');
    }

    public function address()
    {
        $addresses = $this->addressService->listByUser($this->user());

        return $this->view('frontend.pages.profile.address.index', compact('addresses'));
    }
}
