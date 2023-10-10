<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListMenuResponseContract;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends BaseApiController
{
    public $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index(Request $request)
    {
        $menus = $this->menuService->searchByAdmin($request->all());

        return $this->response(ListMenuResponseContract::class, $menus);
    }
}
