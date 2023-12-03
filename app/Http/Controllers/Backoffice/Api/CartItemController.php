<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListCartItemResponseContract;
use App\Services\CartItemService;
use Illuminate\Http\Request;

class CartItemController extends BaseApiController
{
    public $cartItemService;

    public function __construct(CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function index(Request $request)
    {
        $carts = $this->cartItemService->searchByAdmin($request->all());

        return $this->response(ListCartItemResponseContract::class, $carts);
    }
}
