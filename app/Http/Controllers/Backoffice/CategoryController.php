<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreCategoryRequestContract;
use App\Contracts\Requests\Backoffice\UpdateCategoryRequestContract;
use App\Contracts\Responses\Backoffice\StoreCategoryResponseContract;
use App\Contracts\Responses\Backoffice\UpdateCategoryResponseContract;
use App\Services\CategoryGroupService;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    public $categoryService;
    public $categoryGroupService;

    public function __construct(CategoryService $categoryService, CategoryGroupService $categoryGroupService)
    {
        $this->categoryService = $categoryService;
        $this->categoryGroupService = $categoryGroupService;
    }

    public function index()
    {
        return view('backoffice.pages.categories.index');
    }

    public function create()
    {
        $categoryGroups = $this->categoryGroupService->allAvailable();

        return view('backoffice.pages.categories.create', compact('categoryGroups'));
    }

    public function edit($id)
    {
        $category = $this->categoryService->show($id);
        $categoryGroups = $this->categoryGroupService->allAvailable();

        return view('backoffice.pages.categories.edit', compact('category', 'categoryGroups'));
    }

    public function store(StoreCategoryRequestContract $request)
    {
        $category = $this->categoryService->create($request->validated());

        return $this->response(StoreCategoryResponseContract::class, $category);
    }

    public function update(UpdateCategoryRequestContract $request, $id)
    {
        $category = $this->categoryService->update($request->validated(), $id);

        return $this->response(UpdateCategoryResponseContract::class, $category);
    }
}
