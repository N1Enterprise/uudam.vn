<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\GetProviderShippingFreeContract;
use App\Contracts\Responses\Frontend\UserCheckoutShippingFeeHistoryResponseContract;
use App\Exceptions\ModelNotFoundException;
use App\Services\CartItemService;
use App\Services\CartService;
use App\Services\UserCheckoutService;
use App\Vendors\Localization\Money;
use Exception;

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

    public function getShippingFee(GetProviderShippingFreeContract $request, $cartUuid)
    {
        $user = $this->user();

        $cart = $this->cartService->findByUser($user->getKey(), ['currency_code' => $user->currency_code]);

        if ($cart->uuid != $cartUuid) {
            return ['message' => 'invalid'];
        }

        $shippingHistory = $this->userCheckoutService->handleCartShippingFeeByShippingOption($cart, $request->shipping_option_id, $request->address_id);

        return $this->response(UserCheckoutShippingFeeHistoryResponseContract::class, $shippingHistory);
    }
}
