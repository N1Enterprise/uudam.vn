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
                        'link' => route('bo.web.products.index'),
                        'permissions' => ['products.index']
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
                'name' => 'Systems',
                'icon' => 'flaticon2-settings',
                'subs' => [
                    [
                        'name' => 'System Setting',
                        'link' => route('bo.web.system-settings.index'),
                        'permissions' => ['system-settings.index'],
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
                    ]
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
