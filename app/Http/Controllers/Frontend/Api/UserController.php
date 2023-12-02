<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\UserPasswordRequestContract;
use App\Contracts\Requests\Frontend\UserUpdateInfoRequestContract;
use App\Services\UserService;

class UserController extends BaseApiController
{
    public $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    public function updateInfo(UserUpdateInfoRequestContract $request)
    {
        $user = $this->userService->updateInfo($request->validated(), $this->user()->getKey());

        $response = optional($user)->only(['id', 'name', 'email', 'phone_number', 'birthday']);

        return response()->json($response);
    }

    public function updatePassword(UserPasswordRequestContract $request)
    {
        $user = $this->userService->changePassword($this->user()->getKey(), $request->password);

        $response = optional($user)->only(['id', 'name', 'email', 'phone_number', 'birthday']);

        return response()->json($response);
    }
}
