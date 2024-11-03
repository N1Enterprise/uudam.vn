<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListHomePageDisplayItemResponseContract;
use App\Services\HomePageDisplayItemService;
use Illuminate\Http\Request;

class HomePageDisplayItemController extends BaseApiController
{
    public $homePageDisplayItem;

    public function __construct(HomePageDisplayItemService $homePageDisplayItem)
    {
        $this->homePageDisplayItem = $homePageDisplayItem;
    }

    public function index(Request $request)
    {
        $homePageDisplayItems = $this->homePageDisplayItem->searchByAdmin($request->all());

        return $this->response(ListHomePageDisplayItemResponseContract::class, $homePageDisplayItems);
    }
}
