<?php

namespace App\Http\Controllers\Frontend;

use App\Services\UserService;

class UserCheckoutController extends AuthenticatedController
{
    public $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    public function index()
    {
        return $this->view('frontend.pages.checkouts.index');
    }
}
