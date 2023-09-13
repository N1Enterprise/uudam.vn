<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Contracts\Requests\Backoffice\UpdateUserRequestContract;
use App\Contracts\Responses\Backoffice\UpdateUserResponseContract;
use App\Enum\UserStatusEnum;
use App\Services\UserService;

class UserController extends BaseController
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $userStatus = UserStatusEnum::labels();

        return $this->view('backoffice.pages.users.index', compact('userStatus'));
    }

    public function edit($id)
    {
        $user = $this->userService->show($id, ['userDetail.country', 'userDetail.state', 'userDetail.city']);

        return $this->view('backoffice.pages.users.edit', compact('user'));
    }

    public function setTestUser(Request $request, $id)
    {
        $user = $this->userService->update(['is_test_user' => true], $id);

        return $this->response(UpdateUserResponseContract::class, $user);
    }

    public function update(UpdateUserRequestContract $request, $id)
    {
        $user = $this->userService->updateInfo($request->validated(), $id);

        return $this->response(UpdateUserResponseContract::class, $user);
    }
}
