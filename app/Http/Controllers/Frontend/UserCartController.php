<?php

namespace App\Http\Controllers\Frontend;

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
        $cart = $this->cartService->findByUser($this->user()->getKey());
        $items = $this->cartItemService->searchPendingItemsByUser($this->user()->getKey());

        return $this->view('frontend.pages.carts.index', compact('cart', 'items'));
    }
}
