<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\UserAddToCartRequestContract;
use App\Contracts\Responses\Frontend\UserUpdateCartItemQuantityResponseContract;
use App\Services\CartItemService;
use App\Services\CartService;
use Illuminate\Http\Request;

class UserCartController extends BaseApiController
{
    public $cartService;
    public $cartItemService;

    public function __construct(CartService $cartService, CartItemService $cartItemService)
    {
        parent::__construct();

        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
    }

    public function store(UserAddToCartRequestContract $request)
    {
        $attributes = array_merge($request->validated(), ['ip_address' => $request->ip()]);

        $cart = $this->cartService->createByUser($this->user()->getKey(), $attributes);

        $response = optional($cart)->only([
            'id',
            'total_item',
            'total_quantity',
            'total_price'
        ]);

        return response()->json($response);
    }

    public function updateItemQuantity(Request $request, $id)
    {
        $cartItem = $this->cartItemService->updateQuantityByUser($this->user()->getKey(), $id, $request->quantity);

        return $this->response(UserUpdateCartItemQuantityResponseContract::class, $cartItem);
    }

    public function cartInfo(Request $request)
    {
        $cart = $this->cartService->findByUser(
            $this->user()->getKey(),
            array_merge($request->all(), [
                'currency_code' => $this->user()->currency_code
            ])
        );

        $response = optional($cart)->only([
            'id',
            'total_item',
            'total_quantity',
            'total_price'
        ]);

        return response()->json($response);
    }

    public function cancel(Request $request, $id)
    {
        $this->cartItemService->cancelByUser($this->user()->getKey(), $id, $request->all());

        return response()->json(['status' => true]);
    }
}
