<?php

use App\Models;

return [
    'size' => [
        'default' => [
            'width'   => 100 * 2,
            'height'  => 100 * 2,
            'quality' => 100,
            'ratio'   => 1/1,
            'quality' => 100,
        ],
        Models\ProductCombo::class => [
            'width'   => 270 * 2,
            'height'  => 345 * 2,
            'quality' => 100,
            'ratio'   => 270 / 345,
            'ext'     => 'jpeg',
        ],
        Models\Banner::class => [],
        Models\Carrier::class => [],
        Models\Category::class => [],
        Models\CategoryGroup::class => [],
        Models\Collection::class => [],
        Models\Inventory::class => [],
        Models\Menu::class => [],
        Models\PaymentOption::class => [],
        Models\PostCategory::class => [],
        Models\Post::class => [],
        Models\Product::class => [],
    ],
];
