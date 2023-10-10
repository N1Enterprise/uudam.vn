<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StorePostRequestContract;
use App\Contracts\Requests\Backoffice\UpdatePostRequestContract;
use App\Contracts\Responses\Backoffice\DeletePostResponseContract;
use App\Contracts\Responses\Backoffice\StorePostResponseContract;
use App\Contracts\Responses\Backoffice\UpdatePostResponseContract;
use App\Services\PostCategoryService;
use App\Services\PostService;

class PostController extends BaseController
{
    public $postService;
    public $postCategoryService;

    public function __construct(PostService $postService, PostCategoryService $postCategoryService)
    {
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
    }

    public function index()
    {
        return view('backoffice.pages.posts.index');
    }

    public function create()
    {
        $postCategories = $this->postCategoryService->allAvailable(['columns' => ['id', 'name']]);

        return view('backoffice.pages.posts.create', compact('postCategories'));
    }

    public function edit($id)
    {
        $post = $this->postService->show($id);
        $postCategories = $this->postCategoryService->allAvailable(['columns' => ['id', 'name']]);

        return view('backoffice.pages.posts.edit', compact('post', 'postCategories'));
    }

    public function store(StorePostRequestContract $request)
    {
        $post = $this->postService->create($request->validated());

        return $this->response(StorePostResponseContract::class, $post);
    }

    public function update(UpdatePostRequestContract $request, $id)
    {
        $post = $this->postService->update($request->validated(), $id);

        return $this->response(UpdatePostResponseContract::class, $post);
    }

    public function destroy($id)
    {
        $status = $this->postService->delete($id);

        return $this->response(DeletePostResponseContract::class, ['status' => $status]);
    }
}
