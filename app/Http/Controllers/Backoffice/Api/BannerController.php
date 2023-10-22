<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListBannerResponseContract;
use App\Services\BannerService;
use Illuminate\Http\Request;

class BannerController extends BaseApiController
{
    public $categoryGroupService;

    public function __construct(BannerService $categoryGroupService)
    {
        $this->categoryGroupService = $categoryGroupService;
    }

    public function index(Request $request)
    {
        $categoryGroups = $this->categoryGroupService->searchByAdmin($request->all());

        return $this->response(ListBannerResponseContract::class, $categoryGroups);
    }
}
