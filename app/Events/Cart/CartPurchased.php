<?php

namespace App\Events\Cart;

use App\Models\Cart;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartPurchased
{
    use SerializesModels;
    use Dispatchable;

    public $cart;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
}
