<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreMenuSubGroupRequestContract;
use App\Contracts\Requests\Backoffice\UpdateMenuSubGroupRequestContract;
use App\Contracts\Responses\Backoffice\DeleteMenuSubGroupResponseContract;
use App\Contracts\Responses\Backoffice\StoreMenuSubGroupResponseContract;
use App\Contracts\Responses\Backoffice\UpdateMenuSubGroupResponseContract;
use App\Services\MenuGroupService;
use App\Services\MenuSubGroupService;

class MenuSubGroupController extends BaseController
{
    public $menuSubGroupService;
    public $menuGroupService;

    public function __construct(MenuSubGroupService $menuSubGroupService, MenuGroupService $menuGroupService)
    {
        $this->menuSubGroupService = $menuSubGroupService;
        $this->menuGroupService = $menuGroupService;
    }

    public function index()
    {
        return view('backoffice.pages.menu-sub-groups.index');
    }

    public function create()
    {
        $menuGroups = $this->menuGroupService->allAvailable(['columns' => ['id', 'name']]);

        return view('backoffice.pages.menu-sub-groups.create', compact('menuGroups'));
    }

    public function edit($id)
    {
        $menuSubGroup = $this->menuSubGroupService->show($id);

        $menuGroups = $this->menuGroupService->allAvailable(['columns' => ['id', 'name']]);

        return view('backoffice.pages.menu-sub-groups.edit', compact('menuSubGroup', 'menuGroups'));
    }

    public function store(StoreMenuSubGroupRequestContract $request)
    {
        $menuSubGroup = $this->menuSubGroupService->create($request->validated());

        return $this->response(StoreMenuSubGroupResponseContract::class, $menuSubGroup);
    }

    public function update(UpdateMenuSubGroupRequestContract $request, $id)
    {
        $menuSubGroup = $this->menuSubGroupService->update($request->validated(), $id);

        return $this->response(UpdateMenuSubGroupResponseContract::class, $menuSubGroup);
    }

    public function destroy($id)
    {
        $status = $this->menuSubGroupService->delete($id);

        return $this->response(DeleteMenuSubGroupResponseContract::class, ['status' => $status]);
    }
}
