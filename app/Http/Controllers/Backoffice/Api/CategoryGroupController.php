<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListCategoryGroupResponseContract;
use App\Services\CategoryGroupService;
use Illuminate\Http\Request;

class CategoryGroupController extends BaseApiController
{
    public $categoryGroupService;

    public function __construct(CategoryGroupService $categoryGroupService)
    {
        $this->categoryGroupService = $categoryGroupService;
    }

    public function index(Request $request)
    {
        $categoryGroups = $this->categoryGroupService->searchByAdmin($request->all());

        return $this->response(ListCategoryGroupResponseContract::class, $categoryGroups);
    }
}
