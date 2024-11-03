<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Repositories\Contracts\OrderItemRepositoryContract;
use App\Services\BaseService;
use App\Vendors\Localization\Money;
use Illuminate\Support\Facades\DB;

class OrderItemService extends BaseService
{
    public $orderItemRepository;
    public $userService;
    public $cartService;
    public $cartItemService;

    public function __construct(
        OrderItemRepositoryContract $orderItemRepository,
        UserService $userService,
        CartService $cartService,
        CartItemService $cartItemService
    ) {
        $this->orderItemRepository = $orderItemRepository;
        $this->userService = $userService;
        $this->cartService = $cartService;
        $this->cartItemService = $cartItemService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->orderItemRepository
            ->with(['order', 'inventory', 'user'])
            ->whereColumnsLike($data['query'] ?? null, ['quantity', 'price', 'currency_code'])
            ->scopeQuery(function($q) use ($data) {
                if ($orderId = data_get($data, 'order_id')) {
                    $q->where('order_id', $orderId);
                }

                if ($inventoryId = data_get($data, 'inventory_id')) {
                    $q->where('inventory_id', $inventoryId);
                }

                if ($userId = data_get($data, 'user_id')) {
                    $q->where('user_id', $userId);
                }

                if ($currencyCode = data_get($data, 'currency_code')) {
                    $q->where('currency_code', $currencyCode);
                }
            })
            ->search([]);

        return $result;
    }

    public function createListFormInventoryDataByUser($userId, $items, $orderId, $data = [])
    {
        return DB::transaction(function() use ($userId, $items, $orderId, $data) {
            /** @var User */
            $user = $this->userService->show($userId);

            $orderItems = $items->map(function($item) use ($orderId, $user) {
                return [
                    'order_id' => BaseModel::getModelKey($orderId),
                    'user_id' => BaseModel::getModelKey($user),
                    'currency_code' => $user->currency_code,
                    'inventory_id' => data_get($item, 'inventory_id'),
                    'quantity' => data_get($item, 'quantity'),
                    'price' => (string) data_get($item, 'final_price'),
                    'total_price' => (string) Money::make(data_get($item, 'final_price'), $user->currency_code)->multipliedBy(data_get($item, 'quantity')),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            })->toArray();

            DB::table('order_items')->insert($orderItems);
        });
    }

    public function createListFormCartByUser($userId, $cartId, $orderId, $data = [])
    {
        return DB::transaction(function() use ($userId, $cartId, $orderId, $data) {
            /** @var User */
            $user = $this->userService->show($userId);

            /** @var Cart */
            $cart = $this->cartService->show($cartId);

            $cartItems = $this->cartItemService->searchPendingItemsByUser($user->getKey(), [
                'currency_code' => $user->currency_code,
                'cart_id' => BaseModel::getModelKey($cart)
            ]);

            $orderItems = [];

            foreach ($cartItems as $cartItem) {
                $orderItems[] = [
                    'order_id' => BaseModel::getModelKey($orderId),
                    'user_id' => BaseModel::getModelKey($user),
                    'currency_code' => $cartItem->currency_code,
                    'inventory_id' => $cartItem->inventory_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total_price' => $cartItem->total_price,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            DB::table('order_items')->insert($orderItems);
        });
    }
}
