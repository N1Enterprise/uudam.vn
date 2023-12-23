<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListHomePageDisplayOrderResponseContract;
use App\Services\HomePageDisplayOrderService;
use Illuminate\Http\Request;

class HomePageDisplayOrderController extends BaseApiController
{
    public $homePageDisplayOrder;

    public function __construct(HomePageDisplayOrderService $homePageDisplayOrder)
    {
        $this->homePageDisplayOrder = $homePageDisplayOrder;
    }

    public function index(Request $request)
    {
        $homePageDisplayOrders = $this->homePageDisplayOrder->searchByAdmin($request->all());

        return $this->response(ListHomePageDisplayOrderResponseContract::class, $homePageDisplayOrders);
    }
}
