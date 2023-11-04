<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\UserSigninRequestContract;
use App\Contracts\Requests\Frontend\UserSignupRequestContract;
use App\Services\UserAuthService;

class UserAuthenticationController extends BaseApiController
{
    public $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        parent::__construct();

        $this->userAuthService = $userAuthService;
    }

    public function signup(UserSignupRequestContract $request)
    {
        $user = $this->userAuthService->signup($request->validated());

        $this->userAuth->login($user);

        return response()->json($user->only(['username']));
    }

    public function signin(UserSigninRequestContract $request)
    {
        $user = $this->userAuthService->signin($request->validated());

        return response()->json($user->only(['username']));
    }

    public function signout()
    {
        $this->userAuth->logout();

        return $this->responseNoContent();
    }
}
