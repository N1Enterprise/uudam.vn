<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListPostCategoryResponseContract;
use App\Services\PostCategoryService;
use Illuminate\Http\Request;

class PostCategoryController extends BaseApiController
{
    public $postCategoryService;

    public function __construct(PostCategoryService $postCategoryService)
    {
        $this->postCategoryService = $postCategoryService;
    }

    public function index(Request $request)
    {
        $postCategories = $this->postCategoryService->searchByAdmin($request->all());

        return $this->response(ListPostCategoryResponseContract::class, $postCategories);
    }
}
