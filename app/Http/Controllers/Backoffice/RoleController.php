<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreRoleRequestContract;
use App\Contracts\Requests\Backoffice\UpdateRoleRequestContract;
use App\Contracts\Responses\Backoffice\StoreRoleResponseContract;
use App\Contracts\Responses\Backoffice\UpdateRoleResponseContract;
use App\Http\Controllers\Backoffice\BaseController;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        return $this->view('backoffice.pages.roles.index');
    }

    public function create(Request $request)
    {
        $groups = $this->roleService::getGroupedPermissions();

        return $this->view('backoffice.pages.roles.create', compact('groups'));
    }

    public function edit(Request $request, $id)
    {
        $role = $this->roleService->show($id);

        $groups = $this->roleService::getGroupedPermissions();

        return $this->view('backoffice.pages.roles.edit', compact('role', 'groups'));
    }

    public function store(StoreRoleRequestContract $request)
    {
        $role = $this->roleService->create($request->validated());

        return $this->response(StoreRoleResponseContract::class, $role);
    }

    public function update(UpdateRoleRequestContract $request, $id)
    {
        $role = $this->roleService->update($request->validated(), $id);

        return $this->response(UpdateRoleResponseContract::class, $role);
    }
}
