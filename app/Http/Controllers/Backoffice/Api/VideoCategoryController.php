<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListVideoCategoryResponseContract;
use App\Services\VideoCategoryService;
use Illuminate\Http\Request;

class VideoCategoryController extends BaseApiController
{
    public $videoCategory;

    public function __construct(VideoCategoryService $videoCategory)
    {
        $this->videoCategory = $videoCategory;
    }

    public function index(Request $request)
    {
        $videoCategories = $this->videoCategory->searchByAdmin($request->all());

        return $this->response(ListVideoCategoryResponseContract::class, $videoCategories);
    }
}
