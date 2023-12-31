<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\UserForgotPasswordRequestContract;
use App\Contracts\Requests\Frontend\UserResetPasswordRequestContract;
use App\Contracts\Requests\Frontend\UserSigninRequestContract;
use App\Contracts\Requests\Frontend\UserSignupRequestContract;
use App\Services\UserAuthService;
use App\Services\UserService;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class UserAuthenticationController extends BaseApiController
{
    public $userAuthService;
    public $userService;

    public function __construct(UserAuthService $userAuthService, UserService $userService)
    {
        parent::__construct();

        $this->userAuthService = $userAuthService;
        $this->userService = $userService;
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

    public function forgotPassword(UserForgotPasswordRequestContract $request)
    {
        $status = $this->userAuth->forgotPassword($request->validated());

        return response()->json(['status' => $status, 'message' => __($status)]);
    }

    public function resetPassword(UserResetPasswordRequestContract $request)
    {
        $status = $this->userAuth->resetPassword(
            $request->validated(),
            function ($player, $password) {
                $this->userService->changePassword($player, $password);
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages(['token' => __(Password::INVALID_TOKEN)]);
        }

        return response()->json(['status' => $status, 'message' => __($status)]);
    }
}
