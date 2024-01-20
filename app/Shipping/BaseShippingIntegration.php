<?php

namespace App\Shipping;

use App\Models\Cart;
use App\Shipping\Contracts\ProviderNamingContract;
use App\Models\ShippingProvider;
use App\Models\User;
use App\Services\CartItemService;

/**
 * Base payment integration class
 */
abstract class BaseShippingIntegration implements ProviderNamingContract
{
    /**
     * @var ShippingProvider
     */
    public $provider;
    public $user = null;
    public $cart = null;

    public function __construct(ShippingProvider $provider)
    {
        $this->provider = $provider;
    }

    abstract public function getProviderQuotation();

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    public function getCartItems()
    {
        if (empty($this->cart)) {
            throw new \Exception('[Shipping Service] Missing Cart.');
        }

        if (empty($this->user)) {
            throw new \Exception('[Shipping Service] Missing User.');
        }

        $cartItems = CartItemService::make()->searchPendingItemsByUser($this->user->getKey(), [
            'currency_code' => $this->user->currency_code,
            'cart_id' => $this->cart->getKey(),
        ]);

        dd($cartItems);
    }
}
