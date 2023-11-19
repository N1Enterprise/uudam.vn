<?php

namespace App\Services;

use App\Enum\CartItemStatusEnum;
use App\Repositories\Contracts\CartItemRepositoryContract;
use App\Repositories\Contracts\CartRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Inventory;
use App\Vendors\Localization\Money;
use Illuminate\Support\Str;

class CartService extends BaseService
{
    public $cartRepository;
    public $cartItemRepository;
    public $inventoryService;

    public function __construct(
        CartRepositoryContract $cartRepository,
        CartItemRepositoryContract $cartItemRepository,
        InventoryService $inventoryService
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->inventoryService = $inventoryService;
    }

    public function findByUser($userId, $data = [])
    {
        return $this->cartRepository
            ->with(data_get($data, 'with', []))
            ->firstWhere([
                'user_id' => $userId
            ], data_get($data, 'columns', ['*']));
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
            /** @var Cart */
            $cart = $this->cartRepository->firstOrCreate([
                'user_id' => $userId
            ], [
                'ip_address'     => data_get($attributes, 'ip_address'),
                'total_quantity' => 0,
                'total_price'    => 0,
                'created_at'     => now(),
                'updated_at'     => now()
            ]);

            /** @var Inventory */
            $inventory = $this->inventoryService->show(data_get($attributes, 'inventory_id'));

            $cartItem = $this->cartItemRepository->firstOrCreate([
                'cart_id'      => $cart->getKey(),
                'user_id'      => $userId,
                'inventory_id' => $inventory->getKey(),
                'has_combo'    => data_get($attributes, 'has_combo', 0),
                'status'       => CartItemStatusEnum::PENDING,
            ], [
                'quantity'   => 0,
                'price'      => 0,
                'uuid'       => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $quantity = (int) data_get($attributes, 'quantity', 0);

            $totalPrice = Money::make($inventory->sale_price)->multipliedBy($quantity);

            $cartItem->update([
                'quantity' => DB::raw('quantity + ' . $quantity),
                'price' => $inventory->sale_price,
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
}
