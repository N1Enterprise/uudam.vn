<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreAdminRequestContract;
use App\Contracts\Requests\Backoffice\UpdateAdminRequestContract;
use App\Contracts\Responses\Backoffice\ActiveAdminResponseContract;
use App\Contracts\Responses\Backoffice\DeactivateAdminResponseContract;
use App\Contracts\Responses\Backoffice\StoreAdminResponseContract;
use App\Contracts\Responses\Backoffice\UpdateAdminResponseContract;
use App\Http\Controllers\Backoffice\BaseController;
use App\Services\AdminService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    public $adminService;

    public $roleService;

    public function __construct(AdminService $adminService, RoleService $roleService)
    {
        $this->adminService = $adminService;
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        return $this->view('backoffice.pages.admins.index');
    }

    public function create(Request $request)
    {
        $roles = $this->roleService->all();

        return $this->view('backoffice.pages.admins.create', compact('roles'));
    }

    public function edit(Request $request, $id)
    {
        $roles = $this->roleService->all();
        $admin = $this->adminService->show($id);

        return $this->view('backoffice.pages.admins.edit', compact('roles', 'admin'));
    }

    public function store(StoreAdminRequestContract $request)
    {
        $admin = $this->adminService->create($request->validated());

        return $this->response(StoreAdminResponseContract::class, $admin);
    }

    public function update(UpdateAdminRequestContract $request, $id)
    {
        $admin = $this->adminService->update($request->validated(), $id);

        return $this->response(UpdateAdminResponseContract::class, $admin);
    }

    public function active(Request $request, $id)
    {
        $admin = $this->adminService->active($id);

        return $this->response(ActiveAdminResponseContract::class, $admin);
    }

    public function deactivate(Request $request, $id)
    {
        $admin = $this->adminService->deactivate($id);

        return $this->response(DeactivateAdminResponseContract::class, $admin);
    }
}
