<?php

namespace App\Http\Controllers\Frontend;

use App\Models\BaseModel;
use App\Services\CartItemService;
use App\Services\CartService;
use Illuminate\Http\Request;

class UserCartController extends AuthenticatedController
{
    public $cartService;
    public $cartItemService;

    public function __construct(CartService $cartService, CartItemService $cartItemService)
    {
        parent::__construct();

        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
    }

    public function index(Request $request)
    {
        $user = $this->user();

        $cart = $this->cartService->findByUser($user->getKey());

        $items = $this->cartItemService->searchPendingItemsByUser($user->getKey(), [
            'currency_code' => $user->currency_code,
            'cart_id' => BaseModel::getModelKey($cart)
        ]);

        return $this->view('frontend.pages.carts.index', compact('cart', 'items'));
    }
}
