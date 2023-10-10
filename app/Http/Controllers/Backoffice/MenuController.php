<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreMenuRequestContract;
use App\Contracts\Requests\Backoffice\UpdateMenuRequestContract;
use App\Contracts\Responses\Backoffice\DeleteMenuResponseContract;
use App\Contracts\Responses\Backoffice\StoreMenuResponseContract;
use App\Contracts\Responses\Backoffice\UpdateMenuResponseContract;
use App\Enum\MenuTypeEnum;
use App\Services\InventoryService;
use App\Services\MenuGroupService;
use App\Services\MenuService;

class MenuController extends BaseController
{
    public $menuService;
    public $inventoryService;
    public $postService;
    public $menuGroupService;

    public function __construct(
        MenuService $menuService,
        InventoryService $inventoryService,
        InventoryService $postService,
        MenuGroupService $menuGroupService
    ) {
        $this->menuService = $menuService;
        $this->inventoryService = $inventoryService;
        $this->postService = $postService;
        $this->menuGroupService = $menuGroupService;
    }

    public function index()
    {
        $menuTypeEnumLabels = MenuTypeEnum::labels();

        return view('backoffice.pages.menus.index', compact('menuTypeEnumLabels'));
    }

    public function create()
    {
        $inventories = $this->inventoryService->allAvailable();
        $posts = $this->postService->allAvailable();
        $menuGroups = $this->menuGroupService
            ->allAvailable(['with' => 'menuSubGroups', 'columns' => ['id', 'name']])
            ->filter(fn($item) => !$item->menuSubGroups->isEmpty());

        $menuTypeEnumLabels = MenuTypeEnum::labels();

        return view('backoffice.pages.menus.create', compact('menuTypeEnumLabels', 'inventories', 'posts', 'menuGroups'));
    }

    public function edit($id)
    {
        $menu = $this->menuService->show($id);

        return view('backoffice.pages.menus.edit', compact('menu'));
    }

    public function store(StoreMenuRequestContract $request)
    {
        $menu = $this->menuService->create($request->validated());

        return $this->response(StoreMenuResponseContract::class, $menu);
    }

    public function update(UpdateMenuRequestContract $request, $id)
    {
        $menu = $this->menuService->update($request->validated(), $id);

        return $this->response(UpdateMenuResponseContract::class, $menu);
    }

    public function destroy($id)
    {
        $status = $this->menuService->delete($id);

        return $this->response(DeleteMenuResponseContract::class, ['status' => $status]);
    }
}
