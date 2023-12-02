<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListCartResponseContract;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends BaseApiController
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $carts = $this->cartService->searchByAdmin($request->all());

        return $this->response(ListCartResponseContract::class, $carts);
    }
}
