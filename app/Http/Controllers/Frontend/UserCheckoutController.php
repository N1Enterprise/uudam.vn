<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\DepositStatusEnum;
use App\Enum\OrderStatusEnum;
use App\Models\Order;
use App\Services\AddressService;
use App\Services\CartItemService;
use App\Services\CartService;
use App\Services\DepositTransactionService;
use App\Services\OrderService;
use App\Services\PageService;
use App\Services\PaymentOptionService;
use App\Services\ShippingOptionService;
use App\Services\ShippingRateService;
use App\Vendors\Localization\Country;
use Illuminate\Http\Request;
use App\Models\DepositTransaction;
use App\Services\DepositService;

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
    public $shippingOptionService;
    public $depositTransactionService;
    public $depositService;

    public function __construct(
        CartService $cartService,
        CartItemService $cartItemService,
        PaymentOptionService $paymentOptionService,
        ShippingRateService $shippingRateService,
        PageService $pageService,
        OrderService $orderService,
        AddressService $addressService,
        ShippingOptionService $shippingOptionService,
        DepositTransactionService $depositTransactionService,
        DepositService $depositService
    ) {
        parent::__construct();

        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
        $this->paymentOptionService = $paymentOptionService;
        $this->shippingRateService = $shippingRateService;
        $this->pageService = $pageService;
        $this->orderService = $orderService;
        $this->addressService = $addressService;
        $this->shippingOptionService = $shippingOptionService;
        $this->depositTransactionService = $depositTransactionService;
        $this->depositService = $depositService;
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
        $cart = $this->cartService->findByUser($user->getKey(), ['currency_code' => $user->currency_code, 'uuid' => $uuid], false);

        if (
            $cart->order_id
            && $cart->order instanceof Order
            && $cart->order->isPendingPayment()
        ) {
            $this->depositService->cancel($cart->order->deposit_transaction_id, ['note' => 'CANCLED_BY_USER_REORDER']);

            return redirect()->route('fe.web.user.checkout.repayment', $cart->order->order_code);
        }

        if (empty($cart)) {
            return redirect()->route('fe.web.home', ['Response_Code' => 'Order_Has_Been_Processed']);
        }

        $cartItems = $this->cartItemService->searchPendingItemsByUser($user->getKey(), [
            'currency_code' => $user->currency_code,
            'cart_id' => $cart->getKey()
        ]);

        $countries = Country::make()->all(['columns' => ['native']]);

        $paymentOptions = $this->paymentOptionService->searchForGuest(['currency_code' => $user->currency_code]);

        $checkoutPages = $this->pageService->listByUser(['columns' => ['id', 'name', 'slug'], 'scopes' => ['displayInCheckout']]);

        $editable = true;

        $address = $this->addressService->getDefaultByUserId($user);

        $shippingOptions = $this->shippingOptionService->allAvailableByProvinceCodeForUser(optional($address)->province_code);

        return $this->view('frontend.pages.checkouts.index', compact(
            'editable',
            'order',
            'cart',
            'cartItems',
            'paymentOptions',
            'shippingOptions',
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
            return redirect()->route('fe.web.home', ['Response_Code' => 'Order_Not_Found']);
        }

        $cart = $this->cartService->findByUser($user->getKey(), ['currency_code' => $user->currency_code]);

        if ($cart) {
            return redirect()->route('fe.web.user.checkout.index', $cart->uuid);
        }

        $cart = $order->cart;

        if ($cart->retry_parent_id) {
            $cart = $this->cartService->show($cart->retry_parent_id);
        }

        $cartCloned = $this->cartService->cloneByUser($cart, $user);

        return redirect()->route('fe.web.user.checkout.index', $cartCloned->uuid);
    }

    public function checkoutStatus(Request $request, $uuid)
    {
        $providerResponse = $request->all();

        $user = $this->user();
        $cart = $this->cartService->findByUser($user->getKey(), ['currency_code' => $user->currency_code, 'uuid' => $uuid], false);

        /** @var Order */
        $order = $cart->order;

        /** @var DepositTransaction */
        $depositTransaction = $order->depositTransaction;

        $isPaymentSuccess = in_array($depositTransaction->status, [DepositStatusEnum::APPROVED, DepositStatusEnum::WAIT_FOR_CONFIRMATION]);
        $isOrderSuccess = $isPaymentSuccess && in_array($order->order_status, [OrderStatusEnum::WAITING_FOR_PAYMENT, OrderStatusEnum::PROCESSING, OrderStatusEnum::DELIVERY]);

        return $this->view('frontend.pages.checkouts.payment-status', compact('order', 'isOrderSuccess'));
    }
}
