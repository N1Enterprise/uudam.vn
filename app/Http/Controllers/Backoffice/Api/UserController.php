<?php

namespace App\Http\Controllers\Backoffice\Api;

use Illuminate\Http\Request;
use App\Contracts\Responses\Backoffice\ListUserResponseContract;
use App\Services\UserService;

class UserController extends BaseApiController
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->searchByAdmin($request->all());

        return $this->response(ListUserResponseContract::class, $users);
    }
}
