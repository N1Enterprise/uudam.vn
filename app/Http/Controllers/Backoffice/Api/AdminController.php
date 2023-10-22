<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Requests\Backoffice\UpdateAdminPasswordRequestContract;
use App\Contracts\Requests\Backoffice\UpdateAdminProfileRequestContract;
use App\Contracts\Responses\Backoffice\ListAdminResponseContract;
use App\Contracts\Responses\Backoffice\UpdateAdminProfileResponseContract;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends BaseApiController
{
    public $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index(Request $request)
    {
        $admins = $this->adminService->searchByAdmin($request->all());

        return $this->response(ListAdminResponseContract::class, $admins);
    }

    public function updateCurrentUserProfile(UpdateAdminProfileRequestContract $request)
    {
        $admin = $this->adminService->update([
            'name' => data_get($request->validated(), 'name'),
        ], $this->user()->getKey());

        return $this->response(UpdateAdminProfileResponseContract::class, $admin);
    }

    public function updateCurrentUserPassword(UpdateAdminPasswordRequestContract $request)
    {
        $admin = $this->adminService->update([
            'password' => data_get($request->validated(), 'new_password'),
        ], $this->user()->getKey());

        return $this->response(UpdateAdminProfileResponseContract::class, $admin);
    }
}
