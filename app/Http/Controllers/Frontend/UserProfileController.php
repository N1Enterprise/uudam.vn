<?php

namespace App\Http\Controllers\Frontend;

use App\Services\UserService;

class UserProfileController extends AuthenticatedController
{
    public $userService;
    public $orderService;

    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    public function profile()
    {
        $user = $this->user();

        return $this->view('frontend.pages.profile.user-info', compact('user'));
    }

    public function changePassword()
    {
        return $this->view('frontend.pages.profile.change-password');
    }
}
