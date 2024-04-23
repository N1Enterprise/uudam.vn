<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreMenuRequestContract;
use App\Contracts\Requests\Backoffice\UpdateMenuRequestContract;
use App\Contracts\Responses\Backoffice\DeleteMenuResponseContract;
use App\Contracts\Responses\Backoffice\StoreMenuResponseContract;
use App\Contracts\Responses\Backoffice\UpdateMenuResponseContract;
use App\Enum\MenuTypeEnum;
use App\Services\CollectionService;
use App\Services\InventoryService;
use App\Services\MenuGroupService;
use App\Services\MenuService;
use App\Services\PostService;

class MenuController extends BaseController
{
    public $menuService;
    public $inventoryService;
    public $postService;
    public $menuGroupService;
    public $collectionService;

    public function __construct(
        MenuService $menuService,
        InventoryService $inventoryService,
        PostService $postService,
        MenuGroupService $menuGroupService,
        CollectionService $collectionService
    ) {
        $this->menuService = $menuService;
        $this->inventoryService = $inventoryService;
        $this->postService = $postService;
        $this->menuGroupService = $menuGroupService;
        $this->collectionService = $collectionService;
    }

    public function index()
    {
        $menuTypeEnumLabels = MenuTypeEnum::labels();
        $inventories = $this->inventoryService->allAvailableDistinct();
        $posts = $this->postService->allAvailable();
        $collections = $this->collectionService->allAvailable();
        $menuGroups = $this->menuGroupService
            ->allAvailable(['with' => 'menuSubGroups', 'columns' => ['id', 'name']])
            ->filter(fn($item) => !$item->menuSubGroups->isEmpty());

        return view('backoffice.pages.menus.index', compact(
            'menuTypeEnumLabels',
            'inventories',
            'posts',
            'collections',
            'menuGroups'
        ));
    }

    public function create()
    {
        $inventories = $this->inventoryService->allAvailableDistinct();
        $posts = $this->postService->allAvailable();
        $collections = $this->collectionService->allAvailable();
        $menuGroups = $this->menuGroupService
            ->allAvailable(['with' => 'menuSubGroups', 'columns' => ['id', 'name']])
            ->filter(fn($item) => !$item->menuSubGroups->isEmpty());

        $menuTypeEnumLabels = MenuTypeEnum::labels();

        return view('backoffice.pages.menus.create', compact('menuTypeEnumLabels', 'inventories', 'posts', 'menuGroups', 'collections'));
    }

    public function edit($id)
    {
        $menu = $this->menuService->show($id, ['with' => 'menuCatalogs']);
        $inventories = $this->inventoryService->allAvailableDistinct();
        $posts = $this->postService->allAvailable();
        $collections = $this->collectionService->allAvailable();
        $menuGroups = $this->menuGroupService
            ->allAvailable(['with' => 'menuSubGroups', 'columns' => ['id', 'name']])
            ->filter(fn($item) => !$item->menuSubGroups->isEmpty());

        $menuTypeEnumLabels = MenuTypeEnum::labels();

        return view('backoffice.pages.menus.edit', compact('menu', 'menuTypeEnumLabels', 'inventories', 'posts', 'menuGroups', 'collections'));
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
