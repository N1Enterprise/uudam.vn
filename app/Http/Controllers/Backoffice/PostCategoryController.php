<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StorePostCategoryRequestContract;
use App\Contracts\Requests\Backoffice\UpdatePostCategoryRequestContract;
use App\Contracts\Responses\Backoffice\DeletePostCategoryResponseContract;
use App\Contracts\Responses\Backoffice\StorePostCategoryResponseContract;
use App\Contracts\Responses\Backoffice\UpdatePostCategoryResponseContract;
use App\Services\PostCategoryService;

class PostCategoryController extends BaseController
{
    public $postCategoryService;

    public function __construct(PostCategoryService $postCategoryService)
    {
        $this->postCategoryService = $postCategoryService;
    }

    public function index()
    {
        return view('backoffice.pages.post-categories.index');
    }

    public function create()
    {
        return view('backoffice.pages.post-categories.create');
    }

    public function edit($id)
    {
        $postCategory = $this->postCategoryService->show($id);

        return view('backoffice.pages.post-categories.edit', compact('postCategory'));
    }

    public function store(StorePostCategoryRequestContract $request)
    {
        $postCategory = $this->postCategoryService->create($request->validated());

        return $this->response(StorePostCategoryResponseContract::class, $postCategory);
    }

    public function update(UpdatePostCategoryRequestContract $request, $id)
    {
        $postCategory = $this->postCategoryService->update($request->validated(), $id);

        return $this->response(UpdatePostCategoryResponseContract::class, $postCategory);
    }

    public function destroy($id)
    {
        $status = $this->postCategoryService->delete($id);

        return $this->response(DeletePostCategoryResponseContract::class, ['status' => $status]);
    }
}
