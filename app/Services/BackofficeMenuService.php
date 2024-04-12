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
                'name' => 'Tổng quan',
                'link' => route('bo.web.dashboard'),
                'icon' => 'flaticon2-graphic',
                'permissions' => [],
            ],
            [
                'name' => 'Khách hàng',
                'icon' => 'flaticon-users',
                'subs' => array_filter([
                    [
                        'name' => 'Danh sách khách hàng',
                        'link' => route('bo.web.users.index'),
                        'permissions' => ['users.index'],
                    ],
                ]),
            ],
            [
                'name' => 'Kho sản phẩm',
                'icon' => 'fa fa-tags',
                'subs' => [
                    [
                        'name' => 'Danh mục',
                        'subs' => [
                            [
                                'name' => 'Nhóm danh mục',
                                'link' => route('bo.web.category-groups.index'),
                                'permissions' => ['category-groups.index']
                            ],
                            [
                                'name' => 'Danh mục',
                                'link' => route('bo.web.categories.index'),
                                'permissions' => ['categories.index']
                            ],
                        ]
                    ],
                    [
                        'name' => 'Thuộc tính',
                        'subs' => [
                            [
                                'name' => 'Thuộc tính',
                                'link' => route('bo.web.attributes.index'),
                                'permissions' => ['attributes.index']
                            ],
                            [
                                'name' => 'Biến thể',
                                'link' => route('bo.web.attribute-values.index'),
                                'permissions' => ['attribute-values.index']
                            ],
                        ],
                    ],
                    [
                        'name' => 'Sản phẩm',
                        'permissions' => ['products.index'],
                        'link' => route('bo.web.products.index'),
                    ],
                    [
                        'name' => 'Kho sản phẩm',
                        'link' => route('bo.web.inventories.index'),
                        'permissions' => ['inventories.index'],
                    ],
                    [
                        'name' => 'Bộ sưu tập',
                        'link' => route('bo.web.collections.index'),
                        'permissions' => ['collections.index'],
                    ],
                ],
            ],
            [
                'name' => 'Đơn hàng',
                'icon' => 'fa fa-cart-plus',
                'subs' => [
                    [
                        'name' => 'Danh sách đơn hàng',
                        'link' => route('bo.web.orders.index'),
                        'permissions' => ['orders.index'],
                    ],
                    [
                        'name' => 'Danh sách giỏ hàng',
                        'link' => route('bo.web.carts.index'),
                        'permissions' => ['carts.index'],
                    ],
                ],
            ],
            [
                'name' => 'Vận chuyển',
                'icon' => 'fa fa-truck',
                'subs' => [
                    [
                        'name' => 'Đơn vị vận chuyển',
                        'link' => route('bo.web.shipping-providers.index'),
                        'permissions' => ['shipping-providers.index'],
                    ],
                    [
                        'name' => 'P.T vận chuyển',
                        'link' => route('bo.web.shipping-options.index'),
                        'permissions' => ['shipping-options.index'],
                    ],
                    [
                        'name' => 'Cài đặt vận chuyển',
                        'subs' => [
                            [
                                'name' => 'Khu vực vận chuyển',
                                'link' => route('bo.web.shipping-zones.index'),
                                'permissions' => ['shipping-zones.index'],
                            ],
                            [
                                'name' => 'Giá cước vận chuyển',
                                'link' => route('bo.web.shipping-rates.index'),
                                'permissions' => ['shipping-rates.index'],
                            ],
                        ]
                    ],
                ],
            ],
            [
                'name' => 'Thanh toán',
                'icon' => 'flaticon2-copy',
                'subs' => [
                    [
                        'name' => 'Giao dịch gửi tiền',
                        'link' => route('bo.web.deposit-transactions.index'),
                        'permissions' => ['deposit-transactions.index']
                    ],
                    [
                        'name' => 'Cài đặt thanh toán',
                        'subs' => [
                            [
                                'name' => 'Đơn vị thanh toán',
                                'link' => route('bo.web.payment-providers.index'),
                                'permissions' => ['payment-providers.index'],
                            ],
                            [
                                'name' => 'P.T Thanh toán',
                                'link' => route('bo.web.payment-options.index'),
                                'permissions' => ['payment-providers.index'],
                            ]
                        ]
                    ]
                ],
            ],
            [
                'name' => 'Hỗ trợ khách',
                'icon' => 'flaticon-technology-1',
                'subs' => [
                    [
                        'name' => 'Người đăng ký',
                        'link' => route('bo.web.subscribers.index'),
                        'permissions' => ['subscribers.index'],
                    ],
                    [
                        'name' => 'Đánh giá sản phẩm',
                        'link' => route('bo.web.product-reviews.index'),
                        'permissions' => ['product-reviews.index'],
                    ],
                ],
            ],
            [
                'name' => 'Giao diện',
                'icon' => 'flaticon2-contract',
                'subs' => [
                    [
                        'name' => 'Hiển thị trang chủ',
                        'subs' => [
                            [
                                'name' => 'Danh sách nhóm',
                                'link' => route('bo.web.home-page-display-orders.index'),
                                'permissions' => ['home-page-display-orders.index'],
                            ],
                            [
                                'name' => 'Cấu hình nhóm',
                                'link' => route('bo.web.home-page-display-items.index'),
                                'permissions' => ['home-page-display-items.index'],
                            ],
                        ],
                    ],
                    [
                        'name' => 'Cài đặt banner',
                        'link' => route('bo.web.banners.index'),
                        'permissions' => ['banners.index'],
                    ],
                    [
                        'name' => 'Cấu hình menu',
                        'subs' => [
                            [
                                'name' => 'Nhóm menu',
                                'link' => route('bo.web.menu-groups.index'),
                                'permissions' => ['menu-groups.index'],
                            ],
                            [
                                'name' => 'Nhóm menu phụ',
                                'link' => route('bo.web.menu-sub-groups.index'),
                                'permissions' => ['menu-sub-groups.index'],
                            ],
                            [
                                'name' => 'Menu',
                                'link' => route('bo.web.menus.index'),
                                'permissions' => ['menus.index'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Tiện ích',
                'icon' => 'fa fa-asterisk',
                'subs' => [
                    [
                        'name' => 'Blogs',
                        'subs' => [
                            [
                                'name' => 'Danh mục',
                                'link' => route('bo.web.post-categories.index'),
                                'permissions' => ['post-categories.index'],
                            ],
                            [
                                'name' => 'Bài viết',
                                'link' => route('bo.web.posts.index'),
                                'permissions' => ['posts.index'],
                            ],
                        ],
                    ],
                    [
                        'name' => 'Danh sách trang',
                        'link' => route('bo.web.pages.index'),
                        'permissions' => ['pages.index'],
                    ],
                    [
                        'name' => 'Faqs',
                        'subs' => [
                            [
                                'name' => 'Tạo topic',
                                'link' => route('bo.web.faq-topics.index'),
                                'permissions' => ['faq-topics.index'],
                            ],
                            [
                                'name' => 'Danh sách faq',
                                'link' => route('bo.web.faqs.index'),
                                'permissions' => ['faqs.index'],
                            ]
                        ],
                    ],
                    [
                        'name' => 'Video',
                        'subs' => [
                            [
                                'name' => 'Danh mục',
                                'link' => route('bo.web.video-categories.index'),
                                'permissions' => ['video-categories.index'],
                            ],
                            [
                                'name' => 'Video',
                                'link' => route('bo.web.videos.index'),
                                'permissions' => ['videos.index'],
                            ]
                        ],
                    ]
                ],
            ],
            [
                'name' => 'Khu vực',
                'icon' => 'flaticon-placeholder-3',
                'subs' => [
                    [
                        'name' => 'Quốc gia',
                        'link' => route('bo.web.countries.index'),
                        'permissions' => ['countries.index'],
                    ],
                    [
                        'name' => 'Tiền tệ',
                        'link' => route('bo.web.currencies.index'),
                        'permissions' => ['currencies.index'],
                    ],
                ],
            ],
            [
                'name' => 'Hệ thống',
                'icon' => 'flaticon2-settings',
                'subs' => [
                    [
                        'name' => 'Cấu hình hệ thống',
                        'link' => route('bo.web.system-settings.index'),
                        'permissions' => ['system-settings.index'],
                    ],
                    [
                        'name' => 'Tiền tệ hệ thống',
                        'link' => route('bo.web.system-currencies.index'),
                        'permissions' => ['system-currencies.manage'],
                    ],
                ],
            ],
            [
                'name' => 'Quản trị',
                'icon' => 'flaticon-user-settings',
                'subs' => [
                    [
                        'name' => 'Quản trị viên',
                        'link' => route('bo.web.admins.index'),
                        'permissions' => ['admins.index'],
                    ],
                    [
                        'name' => 'Quyền truy cập',
                        'link' => route('bo.web.roles.index'),
                        'permissions' => ['roles.index'],
                    ],
                ],
            ],
        ];

        static::$menus = $menus;
    }
}
