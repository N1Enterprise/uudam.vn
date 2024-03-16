<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListVideoCategoryResponseContract;
use App\Services\VideoCategoryService;
use Illuminate\Http\Request;

class VideoCategoryController extends BaseApiController
{
    public $videoCategoryService;

    public function __construct(VideoCategoryService $videoCategoryService)
    {
        $this->videoCategoryService = $videoCategoryService;
    }

    public function index(Request $request)
    {
        $videoCategories = $this->videoCategoryService->searchByAdmin($request->all());

        return $this->response(ListVideoCategoryResponseContract::class, $videoCategories);
    }
}
