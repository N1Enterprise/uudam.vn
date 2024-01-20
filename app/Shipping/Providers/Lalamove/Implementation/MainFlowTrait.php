<?php

namespace App\Shipping\Providers\Lalamove\Implementation;

trait MainFlowTrait 
{
    public function getProviderQuotation()
    {
        $items = $this->getCartItems();
    }
}