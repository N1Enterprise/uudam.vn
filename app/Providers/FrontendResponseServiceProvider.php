<?php

namespace App\Providers;

use App\Http\Responses\Frontend as Responses;
use App\Contracts\Responses\Frontend as Contracts;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class FrontendResponseServiceProvider extends ServiceProvider
{
    public $singletons = [
        Contracts\StoreUserProductReviewResponseContract::class => Responses\StoreUserProductReviewResponse::class,
        Contracts\ListLinkedInventoryResponseContract::class => Responses\ListLinkedInventoryResponse::class,
        Contracts\UserUpdateCartItemQuantityResponseContract::class => Responses\UserUpdateCartItemQuantityResponse::class,
        Contracts\UserOrderResponseContract::class => Responses\UserOrderResponse::class,
        Contracts\ListLinkedCollectionResponseContract::class => Responses\ListLinkedCollectionResponse::class,
        Contracts\ListLinkedPostResponseContract::class => Responses\ListLinkedPostResponse::class,
        Contracts\ListLinkedBlogResponseContract::class => Responses\ListLinkedBlogResponse::class,
        Contracts\ListLinkedBannerResponseContract::class => Responses\ListLinkedBannerResponse::class,
        Contracts\StoreUserAddressResponseContract::class => Responses\StoreUserAddressResponse::class,
        Contracts\ShowUserAddressResponseContract::class => Responses\ShowUserAddressResponse::class,
        Contracts\UserCheckoutShippingFeeHistoryResponseContract::class => Responses\UserCheckoutShippingFeeHistoryResponse::class,
        Contracts\ListPostResponseContract::class => Responses\ListPostResponse::class,
    ];
}
