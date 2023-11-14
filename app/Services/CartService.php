<?php

namespace App\Services;

use App\Enum\CartItemStatusEnum;
use App\Repositories\Contracts\CartItemRepositoryContract;
use App\Repositories\Contracts\CartRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Inventory;

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

    public function create($attributes = [])
    {
        return DB::transaction(function() use ($attributes) {
            /** @var Cart */
            $cart = $this->cartRepository->firstOrCreate([
                'user_id' => data_get($attributes, 'user_id')
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
                'cart_id' => $cart->getKey(),
                'inventory_id' => $inventory->getKey(),
                'has_combo' => data_get($attributes, 'has_combo', 0),
            ], [
                'quantity'   => 0,
                'price'      => 0,
                'status'     => CartItemStatusEnum::PENDING,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $cartItem->update([
                'quantity' => DB::raw('quantity + ' . data_get($attributes, 'quantity', 0)),
                'price'    => DB::raw('price + ' . $inventory->sale_price),
            ]);

            $itemsInCart = $cart->items;

            $cart->update([
                'total_item'     => $itemsInCart->count(),
                'total_quantity' => $itemsInCart->sum('quantity'),
                'total_price'    => $itemsInCart->sum('price') * $itemsInCart->sum('quantity'),
            ]);

            return $cart;
        });
    }
}
