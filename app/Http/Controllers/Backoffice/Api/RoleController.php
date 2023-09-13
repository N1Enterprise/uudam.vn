<?php

namespace App\Http\Controllers\Backoffice\Api;

use Illuminate\Http\Request;
use App\Contracts\Responses\Backoffice\ListRoleResponseContract;
use App\Services\RoleService;

class RoleController extends BaseApiController
{
    public $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $admins = $this->roleService->searchByAdmin($request->all());

        return $this->response(ListRoleResponseContract::class, $admins);
    }
}
