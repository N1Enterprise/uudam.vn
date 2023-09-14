<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListCategoryResponseContract;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends BaseApiController
{
    public $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->searchByAdmin($request->all());

        return $this->response(ListCategoryResponseContract::class, $categories);
    }
}
