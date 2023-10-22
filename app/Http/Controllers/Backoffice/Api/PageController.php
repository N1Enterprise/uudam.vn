<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListPageResponseContract;
use App\Services\PageService;
use Illuminate\Http\Request;

class PageController extends BaseApiController
{
    public $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index(Request $request)
    {
        $pages = $this->pageService->searchByAdmin($request->all());

        return $this->response(ListPageResponseContract::class, $pages);
    }
}
