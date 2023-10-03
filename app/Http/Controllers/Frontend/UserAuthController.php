<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Requests\Frontend\SigninRequestContract;
use App\Contracts\Requests\Frontend\SignupRequestContract;
use App\Contracts\Responses\Frontend\SigninResponseContract;
use App\Contracts\Responses\Frontend\SignupResponseContract;
use App\Services\UserAuthService;
use Illuminate\Http\Request;

class UserAuthController extends BaseController
{
    public $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        parent::__construct();

        $this->userAuthService = $userAuthService;
    }

    public function signup(SignupRequestContract $request)
    {
        $user = $this->userAuthService->signup($request->validated());

        $this->userAuth->login($user);

        return $this->response(SignupResponseContract::class, ['success' => true]);
    }

    public function signin(SigninRequestContract $request)
    {
        $user = $this->userAuthService->signin($request->validated());

        return $this->response(SigninResponseContract::class, ['success' => true]);
    }

    public function verifyEmail(Request $request)
    {
        dd('verifyEmail');
    }
}
