<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreCategoryGroupRequestContract;
use App\Contracts\Requests\Backoffice\UpdateCategoryGroupRequestContract;
use App\Contracts\Responses\Backoffice\StoreCategoryGroupResponseContract;
use App\Contracts\Responses\Backoffice\UpdateCategoryGroupResponseContract;
use App\Services\CategoryGroupService;

class CategoryGroupController extends BaseController
{
    public $categoryGroupService;

    public function __construct(CategoryGroupService $categoryGroupService)
    {
        $this->categoryGroupService = $categoryGroupService;
    }

    public function index()
    {
        return view('backoffice.pages.category-groups.index');
    }

    public function create()
    {
        return view('backoffice.pages.category-groups.create');
    }

    public function edit($id)
    {
        $categoryGroup = $this->categoryGroupService->show($id);

        return view('backoffice.pages.category-groups.edit', compact('categoryGroup'));
    }

    public function store(StoreCategoryGroupRequestContract $request)
    {
        $categoryGroup = $this->categoryGroupService->create($request->validated());

        return $this->response(StoreCategoryGroupResponseContract::class, $categoryGroup);
    }

    public function update(UpdateCategoryGroupRequestContract $request, $id)
    {
        $categoryGroup = $this->categoryGroupService->update($request->validated(), $id);

        return $this->response(UpdateCategoryGroupResponseContract::class, $categoryGroup);
    }
}
