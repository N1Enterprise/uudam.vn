<?php

namespace App\Shipping\Helpers;

class ShippingCartHelper
{
    public static function getTotalWeightFromItems($items = [])
    {
        return collect($items)->reduce(function($init, $item) {
            return $init + (
                (int) data_get($item, 'quantity', 0) * (int) data_get($item, 'inventory.meta.volumn.weight', 0)
            );
        }, 0);
    }
}