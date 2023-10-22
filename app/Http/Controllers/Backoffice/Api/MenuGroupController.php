<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListMenuGroupResponseContract;
use App\Services\MenuGroupService;
use Illuminate\Http\Request;

class MenuGroupController extends BaseApiController
{
    public $menuGroupService;

    public function __construct(MenuGroupService $menuGroupService)
    {
        $this->menuGroupService = $menuGroupService;
    }

    public function index(Request $request)
    {
        $menuGroups = $this->menuGroupService->searchByAdmin($request->all());

        return $this->response(ListMenuGroupResponseContract::class, $menuGroups);
    }
}
