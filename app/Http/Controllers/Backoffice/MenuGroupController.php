<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreMenuGroupRequestContract;
use App\Contracts\Requests\Backoffice\UpdateMenuGroupRequestContract;
use App\Contracts\Responses\Backoffice\DeleteMenuGroupResponseContract;
use App\Contracts\Responses\Backoffice\StoreMenuGroupResponseContract;
use App\Contracts\Responses\Backoffice\UpdateMenuGroupResponseContract;
use App\Services\MenuGroupService;

class MenuGroupController extends BaseController
{
    public $menuGroupService;

    public function __construct(MenuGroupService $menuGroupService)
    {
        $this->menuGroupService = $menuGroupService;
    }

    public function index()
    {
        return view('backoffice.pages.menu-groups.index');
    }

    public function create()
    {
        return view('backoffice.pages.menu-groups.create');
    }

    public function edit($id)
    {
        $menuGroup = $this->menuGroupService->show($id);

        return view('backoffice.pages.menu-groups.edit', compact('menuGroup'));
    }

    public function store(StoreMenuGroupRequestContract $request)
    {
        $menuGroup = $this->menuGroupService->create($request->validated());

        return $this->response(StoreMenuGroupResponseContract::class, $menuGroup);
    }

    public function update(UpdateMenuGroupRequestContract $request, $id)
    {
        $menuGroup = $this->menuGroupService->update($request->validated(), $id);

        return $this->response(UpdateMenuGroupResponseContract::class, $menuGroup);
    }

    public function destroy($id)
    {
        $status = $this->menuGroupService->delete($id);

        return $this->response(DeleteMenuGroupResponseContract::class, ['status' => $status]);
    }
}
