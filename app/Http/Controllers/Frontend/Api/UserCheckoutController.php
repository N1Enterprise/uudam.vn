<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Exceptions\ModelNotFoundException;
use App\Services\CartItemService;
use App\Services\CartService;
use App\Services\UserCheckoutService;
use Illuminate\Http\Request;

class UserCheckoutController extends BaseApiController
{
    public $userCheckoutService;
    public $cartItemService;
    public $cartService;

    public function __construct(
        UserCheckoutService $userCheckoutService, 
        CartItemService $cartItemService,
        CartService $cartService
    ) {
        parent::__construct();

        $this->userCheckoutService = $userCheckoutService;
        $this->cartItemService = $cartItemService;
        $this->cartService = $cartService;
    }

    public function getProvidersShippingRate(Request $request, $cartUuid)
    {
        $user = $this->user();

        $cart = $this->cartService->findByUser($user->getKey(), ['currency_code' => $user->currency_code]);

        if ($cart->uuid != $cartUuid) {
            throw new ModelNotFoundException();
        }

        $shippingRates = $this->userCheckoutService->getShippingRateByProviders($this->user(), $request->providers, $cart);
    }
}
