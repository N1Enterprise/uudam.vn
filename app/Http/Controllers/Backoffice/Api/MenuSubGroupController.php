<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListMenuSubGroupResponseContract;
use App\Services\MenuSubGroupService;
use Illuminate\Http\Request;

class MenuSubGroupController extends BaseApiController
{
    public $menuSubGroupService;

    public function __construct(MenuSubGroupService $menuSubGroupService)
    {
        $this->menuSubGroupService = $menuSubGroupService;
    }

    public function index(Request $request)
    {
        $menuGroups = $this->menuSubGroupService->searchByAdmin($request->all());

        return $this->response(ListMenuSubGroupResponseContract::class, $menuGroups);
    }
}
