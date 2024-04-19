<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreUserRequestContract;
use App\Contracts\Requests\Backoffice\UpdateUserActionLogRequestContract;
use App\Contracts\Requests\Backoffice\UpdateUserPasswordRequestContract;
use Illuminate\Http\Request;
use App\Contracts\Requests\Backoffice\UpdateUserRequestContract;
use App\Contracts\Responses\Backoffice\StoreUserResponseContract;
use App\Contracts\Responses\Backoffice\UpdateUserActionLogResponseContract;
use App\Contracts\Responses\Backoffice\UpdateUserResponseContract;
use App\Enum\AccessChannelType;
use App\Enum\UserStatusEnum;
use App\Services\UserService;
use App\Vendors\Localization\SystemCurrency;

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

    public function create(Request $request)
    {
        $currencies = SystemCurrency::all();
        $accessChannelTypeLables = AccessChannelType::labels();

        return $this->view('backoffice.pages.users.create', compact('currencies', 'accessChannelTypeLables'));
    }

    public function edit($id)
    {
        $user = $this->userService->show($id, ['userDetail.country', 'userDetail.state', 'userDetail.city']);
        $accessChannelTypeLables = AccessChannelType::labels();

        return $this->view('backoffice.pages.users.edit', compact('user', 'accessChannelTypeLables'));
    }

    public function setTestUser(Request $request, $id)
    {
        $user = $this->userService->update(['is_test_user' => true], $id);

        return $this->response(UpdateUserResponseContract::class, $user);
    }

    public function store(StoreUserRequestContract $request)
    {
        $user = $this->userService->create($request->validated());

        return $this->response(StoreUserResponseContract::class, $user);
    }

    public function update(UpdateUserRequestContract $request, $id)
    {
        $user = $this->userService->updateInfo($request->validated(), $id);

        return $this->response(UpdateUserResponseContract::class, $user);
    }

    public function updateUserAction(UpdateUserActionLogRequestContract $request, $id)
    {
        $actionLog = $this->userService->handleUserAction($request->validated(), $id);

        if ($actionLog) {
            session()->flash('actionMessage', ($request['type']));

            return $this->response(UpdateUserActionLogResponseContract::class, $actionLog);
        }
    }

    public function updatePassword(UpdateUserPasswordRequestContract $request, $id)
    {
        $user = $this->userService->changePassword($id, $request->password);

        return $this->response(UpdateUserResponseContract::class, $user);
    }
}
