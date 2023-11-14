<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\UserAddToCartRequestContract;
use App\Services\CartService;

class UserCartController extends BaseApiController
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        parent::__construct();

        $this->cartService = $cartService;
    }

    public function store(UserAddToCartRequestContract $request)
    {
        $cart = $this->cartService->create(array_merge($request->validated(), [
            'user_id' => $this->user()->getKey(),
            'ip_address' => $request->ip()
        ]));

        return response()->json(
            optional($cart)->only(['id', 'total_item', 'total_quantity', 'total_price'])
        );
    }

    public function cartInfo()
    {
        $cart = $this->cartService->findByUser($this->user()->getKey());

        return response()->json(
            optional($cart)->only(['id', 'total_item', 'total_quantity', 'total_price'])
        );
    }
}
