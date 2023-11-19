<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts as Contracts;
use App\Repositories;

class RepositoryServiceProvider extends ServiceProvider
{
    public $singletons = [
        Contracts\BaseRepositoryContract::class => Repositories\BaseRepository::class,
        Contracts\RoleRepositoryContract::class => Repositories\RoleRepository::class,
        Contracts\AdminRepositoryContract::class => Repositories\AdminRepository::class,
        Contracts\UserRepositoryContract::class => Repositories\UserRepository::class,
        Contracts\UserDetailRepositoryContract::class => Repositories\UserDetailRepository::class,
        Contracts\SystemSettingRepositoryContract::class => Repositories\SystemSettingRepository::class,
        Contracts\SystemSettingGroupRepositoryContract::class => Repositories\SystemSettingGroupRepository::class,
        Contracts\CategoryGroupRepositoryContract::class => Repositories\CategoryGroupRepository::class,
        Contracts\CategoryRepositoryContract::class => Repositories\CategoryRepository::class,
        Contracts\ProductRepositoryContract::class => Repositories\ProductRepository::class,
        Contracts\AttributeRepositoryContract::class => Repositories\AttributeRepository::class,
        Contracts\AttributeValueRepositoryContract::class => Repositories\AttributeValueRepository::class,
        Contracts\InventoryRepositoryContract::class => Repositories\InventoryRepository::class,
        Contracts\DisplayInventoryRepositoryContract::class => Repositories\DisplayInventoryRepository::class,
        Contracts\BannerRepositoryContract::class => Repositories\BannerRepository::class,
        Contracts\MenuGroupRepositoryContract::class => Repositories\MenuGroupRepository::class,
        Contracts\MenuSubGroupRepositoryContract::class => Repositories\MenuSubGroupRepository::class,
        Contracts\MenuRepositoryContract::class => Repositories\MenuRepository::class,
        Contracts\PostCategoryRepositoryContract::class => Repositories\PostCategoryRepository::class,
        Contracts\PostRepositoryContract::class => Repositories\PostRepository::class,
        Contracts\CollectionRepositoryContract::class => Repositories\CollectionRepository::class,
        Contracts\PageRepositoryContract::class => Repositories\PageRepository::class,
        Contracts\FaqTopicRepositoryContract::class => Repositories\FaqTopicRepository::class,
        Contracts\FaqRepositoryContract::class => Repositories\FaqRepository::class,
        Contracts\ProductReviewRepositoryContract::class => Repositories\ProductReviewRepository::class,
        Contracts\ProductComboRepositoryContract::class => Repositories\ProductComboRepository::class,
        Contracts\FileManagerRepositoryContract::class => Repositories\FileManagerRepository::class,
        Contracts\SubscriberRepositoryContract::class => Repositories\SubscriberRepository::class,
        Contracts\UserActionLogRepositoryContract::class => Repositories\UserActionLogRepository::class,
        Contracts\CartRepositoryContract::class => Repositories\CartRepository::class,
        Contracts\CartItemRepositoryContract::class => Repositories\CartItemRepository::class,
        Contracts\CarrierRepositoryContract::class => Repositories\CarrierRepository::class,
        Contracts\CountryRepositoryContract::class => Repositories\CountryRepository::class,
        Contracts\ShippingZoneRepositoryContract::class => Repositories\ShippingZoneRepository::class,
        Contracts\ShippingRateRepositoryContract::class => Repositories\ShippingRateRepository::class,
        Contracts\PaymentProviderRepositoryContract::class => Repositories\PaymentProviderRepository::class,
    ];
}
