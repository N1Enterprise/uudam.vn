<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreVideoCategoryRequestContract;
use App\Contracts\Requests\Backoffice\UpdateVideoCategoryRequestContract;
use App\Contracts\Responses\Backoffice\DeleteVideoCategoryResponseContract;
use App\Contracts\Responses\Backoffice\StoreVideoCategoryResponseContract;
use App\Contracts\Responses\Backoffice\UpdateVideoCategoryResponseContract;
use App\Services\VideoCategoryService;
use Illuminate\Http\Request;

class VideoCategoryController extends BaseController
{
    public $videoCategoryService;

    public function __construct(VideoCategoryService $videoCategoryService)
    {
        $this->videoCategoryService = $videoCategoryService;
    }

    public function index()
    {
        return view('backoffice.pages.video-categories.index');
    }

    public function create()
    {
        return view('backoffice.pages.video-categories.create');
    }

    public function edit($id)
    {
        $videoCategory = $this->videoCategoryService->show($id);

        return view('backoffice.pages.video-categories.edit', compact('videoCategory'));
    }

    public function store(StoreVideoCategoryRequestContract $request)
    {
        $videoCategory = $this->videoCategoryService->create($request->validated());

        return $this->response(StoreVideoCategoryResponseContract::class, $videoCategory);
    }

    public function update(UpdateVideoCategoryRequestContract $request, $id)
    {
        $videoCategory = $this->videoCategoryService->update($request->validated(), $id);

        return $this->response(UpdateVideoCategoryResponseContract::class, $videoCategory);
    }

    public function destroy(Request $request, $id)
    {
        $status = $this->videoCategoryService->delete($id);

        return $this->response(DeleteVideoCategoryResponseContract::class, $status);
    }
}
