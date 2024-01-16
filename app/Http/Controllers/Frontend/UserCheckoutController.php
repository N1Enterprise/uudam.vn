<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Services\AddressService;
use App\Services\CarrierService;
use App\Services\CartItemService;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PageService;
use App\Services\PaymentOptionService;
use App\Services\ShippingRateService;
use App\Vendors\Localization\Country;
use Illuminate\Http\Request;

class UserCheckoutController extends AuthenticatedController
{
    public $cartService;
    public $cartItemService;
    public $paymentOptionService;
    public $shippingRateService;
    public $pageService;
    public $carrierService;
    public $orderService;
    public $addressService;

    public function __construct(
        CartService $cartService,
        CartItemService $cartItemService,
        PaymentOptionService $paymentOptionService,
        ShippingRateService $shippingRateService,
        PageService $pageService,
        CarrierService $carrierService,
        OrderService $orderService,
        AddressService $addressService
    ) {
        parent::__construct();

        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
        $this->paymentOptionService = $paymentOptionService;
        $this->shippingRateService = $shippingRateService;
        $this->pageService = $pageService;
        $this->carrierService = $carrierService;
        $this->orderService = $orderService;
        $this->addressService = $addressService;
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
        $order = new Order;
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

        $paymentOptions = $this->paymentOptionService->searchForGuest(['currency_code' => $user->currency_code]);

        $checkoutPages = $this->pageService->listByUser(['columns' => ['id', 'name', 'slug'], 'scopes' => ['displayInCheckout']]);
        $shippingRatesCarriers = $this->carrierService->searchCarrierShippingRatePriceGroupedByCart($cart, []);

        $editable = true;

        $address = $this->addressService->getDefaultByUserId($user);

        return $this->view('frontend.pages.checkouts.index', compact(
            'editable', 
            'order', 
            'cart', 
            'cartItems', 
            'paymentOptions', 
            'shippingRatesCarriers', 
            'countries', 
            'checkoutPages',
            'address'
        ));
    }

    public function rePayment(Request $request, $orderCode)
    {
        $order = $this->orderService->findByUserAndCode($this->user()->getKey(), $orderCode);
        $user = $this->user();

        if (empty($order)) {
            return redirect()->route('fe.web.home');
        }

        $cart = $order->cart;

        $cartItems = $this->cartItemService->searchPendingItemsByUser($user->getKey(), [
            'currency_code' => $user->currency_code,
            'cart_id' => $cart->getKey()
        ]);

        $countries = Country::make()->all(['columns' => ['native']]);

        $paymentOptions = $this->paymentOptionService->searchForGuest(['currency_code' => $user->currency_code]);

        $checkoutPages = $this->pageService->listByUser(['columns' => ['id', 'name', 'slug'], 'scopes' => ['displayInCheckout']]);
        $shippingRatesCarriers = $this->carrierService->searchCarrierShippingRatePriceGroupedByCart($cart, []);

        $editable = false;

        return $this->view('frontend.pages.checkouts.index', compact('editable', 'order', 'cart', 'cartItems', 'paymentOptions', 'shippingRatesCarriers', 'countries', 'checkoutPages'));
    }

    public function paymentFailure(Request $request, $orderCode)
    {
        $order = $this->orderService->findByUserAndCode($this->user()->getKey(), $orderCode);

        if (empty($order)) {
            return redirect()->route('fe.web.home');
        }

        return $this->view('frontend.pages.checkouts.payment-status', compact('order'));
    }

    public function paymentSuccess(Request $request, $orderCode)
    {
        $order = $this->orderService->findByUserAndCode($this->user()->getKey(), $orderCode);

        if (empty($order)) {
            return redirect()->route('fe.web.home');
        }

        return $this->view('frontend.pages.checkouts.payment-status', compact('order'));
    }
}
