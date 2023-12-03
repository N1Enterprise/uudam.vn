<?php

namespace App\Http\Controllers\Backoffice;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        return view('backoffice.pages.carts.index');
    }

    public function edit(Request $request, $id)
    {
        $cart = $this->cartService->show($id);

        return view('backoffice.pages.carts.edit', compact('cart'));
    }
}
