<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreOrderRequestContract;
use App\Contracts\Responses\Backoffice\StoreOrderResponseContract;
use App\Enum\AccessChannelType;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Services\InventoryService;
use App\Services\OrderService;
use App\Services\PaymentOptionService;
use App\Services\ShippingOptionService;
use App\Services\ShippingProviderService;
use App\Services\UserOrderService;
use App\Services\UserService;
use App\Vendors\Localization\District;
use App\Vendors\Localization\Province;
use App\Vendors\Localization\Ward;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public $orderService;
    public $shippingProviderService;
    public $inventoryService;
    public $shippingOptionService;
    public $paymentOptionService;
    public $userService;
    public $userOrderService;

    public function __construct(
        OrderService $orderService,
        ShippingProviderService $shippingProviderService,
        InventoryService $inventoryService,
        ShippingOptionService $shippingOptionService,
        PaymentOptionService $paymentOptionService,
        UserService $userService,
        UserOrderService $userOrderService
    ) {
        $this->orderService = $orderService;
        $this->shippingProviderService = $shippingProviderService;
        $this->inventoryService = $inventoryService;
        $this->shippingOptionService = $shippingOptionService;
        $this->paymentOptionService = $paymentOptionService;
        $this->userService = $userService;
        $this->userOrderService = $userOrderService;
    }

    public function index()
    {
        $orderStatusEnumLabels = OrderStatusEnum::labels();
        $paymentStatusEnumLabels = PaymentStatusEnum::labels();
        $accessChannelTypeLables = AccessChannelType::labels();

        return view('backoffice.pages.orders.index', compact('orderStatusEnumLabels', 'paymentStatusEnumLabels', 'accessChannelTypeLables'));
    }

    public function create(Request $request)
    {
        $inventories = $this->inventoryService->allAvailable();
        $shippingOptions = $this->shippingOptionService->allAvailable();
        $shippingProviders = $this->shippingProviderService->allAvailable();
        $paymentOptions = $this->paymentOptionService->allAvailable();
        $provinces = Province::make()->all();
        $districts = District::make()->all(['with' => 'province']);
        $wards = Ward::make()->all(['with' => 'district']);
        $users = $this->userService->allAvailable();
        $accessChannelTypeLables = AccessChannelType::labels();

        return view('backoffice.pages.orders.create', compact(
            'inventories',
            'shippingOptions',
            'shippingProviders',
            'paymentOptions',
            'provinces',
            'districts',
            'wards',
            'users',
            'accessChannelTypeLables'
        ));
    }

    public function store(StoreOrderRequestContract $request)
    {
        $order = $this->userOrderService->orderByAdmin(
            $request->user_id,
            $request->cart_items,
            $request->payment_option_id,
            $request->shipping_option_id,
            [
                'province_code' => $request->province_code,
                'district_code' => $request->district_code,
                'ward_code' => $request->ward_code,
                'postal_code' => $request->postal_code,
                'address_line' => $request->address_line,
            ],
            $this->user(),
            $request->validated()
        );

        return $this->response(StoreOrderResponseContract::class, $order);
    }

    public function edit(Request $request, $id)
    {
        $order = $this->orderService->show($id, ['with' => ['user', 'shippingRate', 'shippingRate.carrier', 'paymentOption', 'orderItems', 'shippingOption']]);
        $orderStatusEnumLabels = OrderStatusEnum::labels();
        $paymentStatusEnumLabels = PaymentStatusEnum::labels();
        $shippingProviders = $this->shippingProviderService->allAvailable();

        return view('backoffice.pages.orders.edit', compact(
            'order',
            'orderStatusEnumLabels',
            'paymentStatusEnumLabels',
            'shippingProviders'
        ));
    }
}
