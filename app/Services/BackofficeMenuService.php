<?php

namespace App\Services;

class BackofficeMenuService extends BaseService
{
    public static $menus = [];

    public function __construct()
    {
        $this->setMenus();
    }

    public function getMenus()
    {
        return static::$menus;
    }

    public function setMenus()
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'link' => route('bo.web.dashboard'),
                'icon' => 'flaticon2-graphic',
                'permissions' => [],
            ],
            [
                'name' => 'Users',
                'icon' => 'flaticon-users',
                'subs' => array_filter([
                    [
                        'name' => 'User List',
                        'link' => route('bo.web.users.index'),
                        'permissions' => ['users.index'],
                    ],
                ]),
            ],
            [
                'name' => 'Catalogs',
                'icon' => 'fa fa-tags',
                'subs' => [
                    [
                        'name' => 'Categories',
                        'subs' => [
                            [
                                'name' => 'Group',
                                'link' => route('bo.web.category-groups.index'),
                                'permissions' => ['category-groups.index']
                            ],
                            [
                                'name' => 'Categories',
                                'link' => route('bo.web.categories.index'),
                                'permissions' => ['categories.index']
                            ],
                        ]
                    ],
                    [
                        'name' => 'Attributes',
                        'subs' => [
                            [
                                'name' => 'Attributes',
                                'link' => route('bo.web.attributes.index'),
                                'permissions' => ['attributes.index']
                            ],
                            [
                                'name' => 'Attribute Values',
                                'link' => route('bo.web.attribute-values.index'),
                                'permissions' => ['attribute-values.index']
                            ],
                        ],
                    ],
                    [
                        'name' => 'Products',
                        'subs' => [
                            [
                                'name' => 'Product',
                                'link' => route('bo.web.products.index'),
                                'permissions' => ['products.index']
                            ],
                            [
                                'name' => 'Product Combos',
                                'link' => route('bo.web.product-combos.index'),
                                'permissions' => ['product-combos.index']
                            ],
                        ]
                    ],
                ],
            ],
            [
                'name' => 'Stock',
                'icon' => 'fa fa-cubes',
                'subs' => [
                    [
                        'name' => 'Inventories',
                        'link' => route('bo.web.inventories.index'),
                        'permissions' => ['inventories.index'],
                    ],
                ],
            ],
            [
                'name' => 'Orders',
                'icon' => 'fa fa-cart-plus',
                'subs' => [
                    [
                        'name' => 'Orders',
                        'link' => route('bo.web.orders.index'),
                        'permissions' => ['orders.index'],
                    ]
                ],
            ],
            [
                'name' => 'Localization',
                'icon' => 'flaticon-placeholder-3',
                'subs' => [
                    [
                        'name' => 'Countries',
                        'link' => route('bo.web.countries.index'),
                        'permissions' => ['countries.index'],
                    ],
                    [
                        'name' => 'Currencies',
                        'link' => route('bo.web.currencies.index'),
                        'permissions' => ['currencies.index'],
                    ],
                ],
            ],
            [
                'name' => 'Shipping',
                'icon' => 'fa fa-truck',
                'subs' => [
                    [
                        'name' => 'Carriers',
                        'link' => route('bo.web.carriers.index'),
                        'permissions' => ['carriers.index'],
                    ],
                    [
                        'name' => 'Shipping Zones',
                        'link' => route('bo.web.shipping-zones.index'),
                        'permissions' => ['shipping-zones.index'],
                    ],
                    [
                        'name' => 'Shipping Rates',
                        'link' => route('bo.web.shipping-rates.index'),
                        'permissions' => ['shipping-rates.index'],
                    ],
                ],
            ],
            [
                'name' => 'Payment',
                'icon' => 'flaticon2-copy',
                'subs' => [
                    [
                        'name' => 'Payment Settings',
                        'subs' => [
                            [
                                'name' => 'Payment Providers',
                                'link' => route('bo.web.payment-providers.index'),
                                'permissions' => ['payment-providers.index'],
                            ],
                            [
                                'name' => 'Payment Options',
                                'link' => route('bo.web.payment-options.index'),
                                'permissions' => ['payment-providers.index'],
                            ]
                        ]
                    ]
                ],
            ],
            [
                'name' => 'Support Desks',
                'icon' => 'flaticon-technology-1',
                'subs' => [
                    [
                        'name' => 'Product Reviews',
                        'link' => route('bo.web.product-reviews.index'),
                        'permissions' => ['product-reviews.index'],
                    ],
                    [
                        'name' => 'Subscribers',
                        'link' => route('bo.web.subscribers.index'),
                        'permissions' => ['subscribers.index'],
                    ],
                ],
            ],
            [
                'name' => 'Appearance',
                'icon' => 'flaticon2-contract',
                'subs' => [
                    [
                        'name' => 'Display Inventories',
                        'link' => route('bo.web.display-inventories.index'),
                        'permissions' => ['display-inventories.index'],
                    ],
                    [
                        'name' => 'Banners',
                        'link' => route('bo.web.banners.index'),
                        'permissions' => ['banners.index'],
                    ],
                    [
                        'name' => 'Menus',
                        'subs' => [
                            [
                                'name' => 'Groups',
                                'link' => route('bo.web.menu-groups.index'),
                                'permissions' => ['menu-groups.index'],
                            ],
                            [
                                'name' => 'Sub Groups',
                                'link' => route('bo.web.menu-sub-groups.index'),
                                'permissions' => ['menu-sub-groups.index'],
                            ],
                            [
                                'name' => 'Menus',
                                'link' => route('bo.web.menus.index'),
                                'permissions' => ['menus.index'],
                            ],
                        ],
                    ],
                    [
                        'name' => 'Collections',
                        'link' => route('bo.web.collections.index'),
                        'permissions' => ['collections.index'],
                    ],
                ],
            ],
            [
                'name' => 'Utilities',
                'icon' => 'fa fa-asterisk',
                'subs' => [
                    [
                        'name' => 'Blogs',
                        'subs' => [
                            [
                                'name' => 'Categories',
                                'link' => route('bo.web.post-categories.index'),
                                'permissions' => ['post-categories.index'],
                            ],
                            [
                                'name' => 'Posts',
                                'link' => route('bo.web.posts.index'),
                                'permissions' => ['posts.index'],
                            ],
                        ],
                    ],
                    [
                        'name' => 'Pages',
                        'link' => route('bo.web.pages.index'),
                        'permissions' => ['pages.index'],
                    ],
                    [
                        'name' => 'Faqs',
                        'subs' => [
                            [
                                'name' => 'Topics',
                                'link' => route('bo.web.faq-topics.index'),
                                'permissions' => ['faq-topics.index'],
                            ],
                            [
                                'name' => 'Faqs',
                                'link' => route('bo.web.faqs.index'),
                                'permissions' => ['faqs.index'],
                            ]
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Systems',
                'icon' => 'flaticon2-settings',
                'subs' => [
                    [
                        'name' => 'System Setting',
                        'link' => route('bo.web.system-settings.index'),
                        'permissions' => ['system-settings.index'],
                    ],
                    [
                        'name' => 'Currency Setting',
                        'link' => route('bo.web.system-currencies.index'),
                        'permissions' => ['system-currencies.manage'],
                    ],
                ],
            ],
            [
                'name' => 'Admin Users',
                'icon' => 'flaticon-user-settings',
                'subs' => [
                    [
                        'name' => 'Admin',
                        'link' => route('bo.web.admins.index'),
                        'permissions' => ['admins.index'],
                    ],
                    [
                        'name' => 'Roles',
                        'link' => route('bo.web.roles.index'),
                        'permissions' => ['roles.index'],
                    ],
                ],
            ],
        ];

        static::$menus = $menus;
    }
}
