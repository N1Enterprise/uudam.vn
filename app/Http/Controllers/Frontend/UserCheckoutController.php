<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\ShippingRateTypeEnum;
use App\Services\CarrierService;
use App\Services\CartItemService;
use App\Services\CartService;
use App\Services\PageService;
use App\Services\PaymentOptionService;
use App\Services\ShippingRateService;
use App\Vendors\Localization\Country;
use App\Vendors\Localization\Money;
use Illuminate\Http\Request;

class UserCheckoutController extends AuthenticatedController
{
    public $cartService;
    public $cartItemService;
    public $paymentOptionService;
    public $shippingRateService;
    public $pageService;

    public function __construct(
        CartService $cartService,
        CartItemService $cartItemService,
        PaymentOptionService $paymentOptionService,
        ShippingRateService $shippingRateService,
        PageService $pageService
    ) {
        parent::__construct();

        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
        $this->paymentOptionService = $paymentOptionService;
        $this->shippingRateService = $shippingRateService;
        $this->pageService = $pageService;
    }

    public function index(Request $request)
    {
        $user = $this->user();

        $cart = $this->cartService->findByUser($user->getKey(), ['currency_code' => $user->currency_code]);

        if (empty($cart)) {
            return redirect()->route('fe.web.home');
        }

        return redirect()->route('fe.web.user.checkout.index', $cart->uuid);
    }

    public function checkout(Request $request, $uuid)
    {
        $user = $this->user();
        $cart = $this->cartService->findByUser($user->getKey(), ['currency_code' => $user->currency_code, 'uuid' => $uuid]);

        if (empty($cart)) {
            return redirect()->route('fe.web.home');
        }

        $cartItems = $this->cartItemService->searchPendingItemsByUser($user->getKey(), [
            'currency_code' => $user->currency_code,
            'cart_id' => $cart->getKey()
        ]);

        $countries = Country::make()->all(['columns' => ['native']]);

        $paymentOptions = $this->paymentOptionService->searchByUser(['currency_code' => $user->currency_code]);

        $shippingRates = $this->shippingRateService->searchByUser([
            'type' => ShippingRateTypeEnum::PRICE,
            'value' => Money::make($cart->total_price, $cart->currency_code)->toFloat(),
        ]);

        $checkoutPages = $this->pageService->listByUser(['columns' => ['id', 'name', 'slug'], 'scopes' => ['displayInCheckout']]);

        $shippingRatesCarriers = collect($shippingRates)->groupBy('carrier.id')->map(function ($group) {
            $carrier = data_get($group->first(), 'carrier');

            $shippingRates = $group ->map(function ($item) {
                return optional($item)->only(['id', 'name', 'delivery_takes', 'rate']);
            })->all();

            return [
                'carrier_id'   => data_get($carrier, 'id'),
                'carrier_name' => data_get($carrier, 'name'),
                'carrier_logo' => data_get($carrier, 'logo'),
                'shipping_rates' => $shippingRates,
            ];
        })
        ->values()
        ->all();

        return $this->view('frontend.pages.checkouts.index', compact('cartItems', 'paymentOptions', 'shippingRatesCarriers', 'countries', 'checkoutPages'));
    }
}
