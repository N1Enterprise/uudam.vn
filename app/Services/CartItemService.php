<?php

namespace App\Services;

use App\Enum\CartItemStatusEnum;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Repositories\Contracts\CartItemRepositoryContract;
use App\Services\BaseService;
use App\Vendors\Localization\Money;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Vendors\Localization\SystemCurrency;

class CartItemService extends BaseService
{
    public $cartItemRepository;

    public function __construct(CartItemRepositoryContract $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->cartItemRepository
        ->with(['cart', 'inventory', 'user'])
        ->whereColumnsLike($data['query'] ?? null, ['uuid', 'currency_code'])
        ->scopeQuery(function($q) use ($data) {
            $cartId = data_get($data, 'cart_id');

            if (! empty($cartId)) {
                $q->where('cart_id', $cartId);
            }
        })
        ->search([]);

    return $result;
    }

    public function searchPendingItemsByUser($userId, $data = [])
    {
        return $this->cartItemRepository
            ->modelScopes(['pending'])
            ->scopeQuery(function($q) use ($userId, $data) {

                if ($currencyCode = data_get($data, 'currency_code')) {
                    $q->where('currency_code', $currencyCode);
                }

                if ($cartId = data_get($data, 'cart_id')) {
                    $q->where('cart_id', $cartId);
                }

                $q->where('user_id', $userId);
            })
            ->all(data_get($data, 'columns', ['*']));
    }

    public function update($attributes, $id)
    {
        return $this->cartItemRepository->update($attributes, $id);
    }

    public function updateQuantityByUser($userId, $id, $quantity)
    {
        return DB::transaction(function() use ($userId, $id, $quantity) {
            $cartItem = $this->cartItemRepository
                ->with(['inventory', 'cart'])
                ->modelScopes(['pending'])
                ->firstWhere([
                    'user_id' => $userId,
                    'id' => $id,
                ]);

            if (empty($cartItem)) {
                throw new BusinessLogicException('Unable to update quantity this item.', ExceptionCode::INVALID_CART_ITEM);
            }

            $inventorySalePrice = $cartItem->inventory->toMoney('final_price');
            $updateTotalPrice = Money::make($inventorySalePrice, SystemCurrency::getDefaultCurrency())->multipliedBy($quantity);

            /** @var Cart */
            $cart = $cartItem->cart;

            $cartItem = $this->update([
                'quantity' => $quantity,
                'price' => (string) $inventorySalePrice,
                'total_price' => (string) $updateTotalPrice
            ], $id);

            $cartItemQuery = DB::table('cart_items')
                ->where('cart_id', $cart->getKey())
                ->where('status', 1);

            DB::table('carts')->where('id', $cart->getKey())
                ->update([
                    'total_quantity' => $cartItemQuery->sum('quantity'),
                    'total_price' => $cartItemQuery->sum('total_price'),
                ]);

            return $cartItem;
        });
    }

    public function findByUser($userId)
    {
        return $this->cartItemRepository->firstWhere([
            'user_id' => $userId
        ]);
    }

    public function cancelByUser($userId, $id, $data = [])
    {
        return DB::transaction(function() use ($userId, $id) {
            $cartItem = $this->findByUser($userId);

            if (empty($cartItem) || $cartItem->id != $id) {
                throw new BusinessLogicException('Invalid Cart Item', ExceptionCode::INVALID_CART_ITEM);
            }

            $cartItem = $this->update(['status' => CartItemStatusEnum::CANCELED], $id);

            $cart = $cartItem->cart;

            $cart->update([
                'total_item' => DB::raw('total_item - 1'),
                'total_quantity' => DB::raw('total_quantity - '. $cartItem->quantity),
                'total_price' => DB::raw('total_price - '. $cartItem->total_price)
            ]);

            return $cartItem;
        });
    }
}
