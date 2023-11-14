<?php

namespace App\Services;

use App\Repositories\Contracts\CartItemRepositoryContract;
use App\Services\BaseService;

class CartItemService extends BaseService
{
    public $cartItemRepository;

    public function __construct(CartItemRepositoryContract $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }

    public function getPendingByCartId($cartId, $data = [])
    {
        return $this->cartItemRepository
            ->modelScopes(['pending'])
            ->scopeQuery(function($q) use ($cartId) {
                $q->where('cart_id', $cartId);
            })
            ->all(data_get($data, 'columns', ['*']));
    }
}
