<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreVideoRequestContract;
use App\Contracts\Requests\Backoffice\UpdateVideoRequestContract;
use App\Contracts\Responses\Backoffice\DeleteVideoResponseContract;
use App\Contracts\Responses\Backoffice\StoreVideoResponseContract;
use App\Contracts\Responses\Backoffice\UpdateVideoResponseContract;
use App\Enum\VideoTypeEnum;
use App\Services\VideoCategoryService;
use App\Services\VideoService;
use Illuminate\Http\Request;

class VideoController extends BaseController
{
    public $videoService;
    public $videoCategoryService;

    public function __construct(VideoService $videoService, VideoCategoryService $videoCategoryService)
    {
        $this->videoService = $videoService;
        $this->videoCategoryService = $videoCategoryService;
    }

    public function index()
    {
        return view('backoffice.pages.videos.index');
    }

    public function create()
    {
        $videoTypeEnumLables = VideoTypeEnum::labels();
        $videoCategories = $this->videoCategoryService->allAvailable();

        return view('backoffice.pages.videos.create', compact('videoTypeEnumLables', 'videoCategories'));
    }

    public function edit($id)
    {
        $video = $this->videoService->show($id);
        $videoTypeEnumLables = VideoTypeEnum::labels();
        $videoCategories = $this->videoCategoryService->allAvailable();

        return view('backoffice.pages.videos.edit', compact('video', 'videoTypeEnumLables', 'videoCategories'));
    }

    public function store(StoreVideoRequestContract $request)
    {
        $video = $this->videoService->create($request->validated());

        return $this->response(StoreVideoResponseContract::class, $video);
    }

    public function update(UpdateVideoRequestContract $request, $id)
    {
        $video = $this->videoService->update($request->validated(), $id);

        return $this->response(UpdateVideoResponseContract::class, $video);
    }

    public function destroy(Request $request, $id)
    {
        $status = $this->videoService->delete($id);

        return $this->response(DeleteVideoResponseContract::class, $status);
    }
}
