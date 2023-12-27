<?php

namespace App\Services;

use App\Enum\CartItemStatusEnum;
use App\Events\Cart\CartPurchased;
use App\Models\BaseModel;
use App\Repositories\Contracts\CartItemRepositoryContract;
use App\Repositories\Contracts\CartRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Inventory;
use App\Vendors\Localization\Money;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Support\Str;
use App\Models\User;

class CartService extends BaseService
{
    public $cartRepository;
    public $cartItemRepository;
    public $inventoryService;
    public $userService;

    public function __construct(
        CartRepositoryContract $cartRepository,
        CartItemRepositoryContract $cartItemRepository,
        InventoryService $inventoryService,
        UserService $userService
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->inventoryService = $inventoryService;
        $this->userService = $userService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->cartRepository
            ->with(['user', 'order'])
            ->whereColumnsLike($data['query'] ?? null, ['uuid', 'ip_address', 'currency_code', 'address_id'])
            ->scopeQuery(function($q) use ($data) {
                if ($userId = data_get($data, 'user_id')) {
                    $q->where('user_id', $userId);
                }

                if ($createdAtRange = data_get($data, 'created_at_range', [])) {
                    $q->whereBetween('created_at', $createdAtRange);
                }

                $q->whereRelation('user', function($q) use ($data) {
                    $userUsernameOrEmail = data_get($data, 'user_username_or_email');

                    if (! empty($userUsernameOrEmail)) {
                        $q->where('username', $userUsernameOrEmail)
                            ->orWhere('name', $userUsernameOrEmail)
                            ->orWhere('email', $userUsernameOrEmail);
                    }

                    $userPhone = data_get($data, 'user_phone_number');

                    if (! empty($userPhone)) {
                        $q->where('phone_number', $userPhone);
                    }
                });

                $q->whereRelation('order', function($q) use ($data) {
                    $orderCode = data_get($data, 'order_code');

                    if (! empty($orderCode)) {
                        $q->where('order_code', $orderCode)
                            ->orWhere('uuid', $orderCode);
                    }
                });
            })
            ->search([]);

        return $result;
    }

    public function findByUser($userId, $data = [])
    {
        return $this->cartRepository
            ->modelScopes(['notOrdered'])
            ->with(data_get($data, 'with', []))
            ->scopeQuery(function($q) use ($data) {
                if ($currencyCode = data_get($data, 'currency_code')) {
                    $q->where('currency_code', $currencyCode);
                }

                if ($uuid = data_get($data, 'uuid')) {
                    $q->where('uuid', $uuid);
                }
            })
            ->firstWhere([ 'user_id' => $userId ]);
    }

    public function show($id)
    {
        return $this->cartRepository->findOrFail($id);
    }

    public function update($attributes = [], $id)
    {
        return $this->cartRepository->update($attributes, $id);
    }

    public function createByUser($userId, $attributes = [])
    {
        return DB::transaction(function() use ($userId, $attributes) {
            /** @var User */
            $user = $this->userService->show($userId);

            $currency = SystemCurrency::get($user->currency());

            /** @var Cart */
            $cart = $this->cartRepository->firstOrCreate([
                'user_id' => $user->getKey(),
                'currency_code' => $currency->getKey(),
                'order_id' => null,
                'ip_address' => data_get($attributes, 'ip_address'),
            ], [
                'total_quantity' => 0,
                'total_price' => 0,
                'uuid' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            /** @var Inventory */
            $inventory = $this->inventoryService->show(data_get($attributes, 'inventory_id'));

            $cartItem = $this->cartItemRepository->firstOrCreate([
                'cart_id' => $cart->getKey(),
                'user_id' => $user->getKey(),
                'inventory_id' => $inventory->getKey(),
                'has_combo' => data_get($attributes, 'has_combo', 0),
                'currency_code' => $currency->getKey(),
                'status' => CartItemStatusEnum::PENDING,
            ], [
                'quantity' => 0,
                'price' => 0,
                'uuid' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $quantity = (int) data_get($attributes, 'quantity', 0);

            $totalPrice = Money::make($inventory->final_price, SystemCurrency::getDefaultCurrency())->multipliedBy($quantity);

            $cartItem->update([
                'quantity' => DB::raw('quantity + ' . $quantity),
                'price' => $inventory->final_price,
                'total_price' => DB::raw('total_price + ' . (string) $totalPrice),
            ]);

            $items = $cart->availableItems;

            $cart->update([
                'total_item'     => $items->count('id'),
                'total_quantity' => $items->sum('quantity'),
                'total_price'    => $items->sum('total_price'),
            ]);

            return $cart;
        });
    }

    public function purchased($cartId, $orderId)
    {
        $cart = $this->show($cartId);
        $order = app(OrderService::class)->show($orderId);

        $this->update(['order_id' => BaseModel::getModelKey($order)], BaseModel::getModelKey($cart));

        CartPurchased::dispatch($cart);

        return $cart;
    }
}
