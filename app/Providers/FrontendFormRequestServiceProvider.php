<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Contracts\Requests\Frontend as Contracts;
use App\Http\Requests\Frontend as Requests;

class FrontendFormRequestServiceProvider extends ServiceProvider
{
    public $singletons = [
        // Authentication
        Contracts\UserSignupRequestContract::class => Requests\UserSignupRequest::class,
        Contracts\UserSigninRequestContract::class => Requests\UserSigninRequest::class,
        Contracts\UserUpdateInfoRequestContract::class => Requests\UserUpdateInfoRequest::class,
        Contracts\UserPasswordRequestContract::class => Requests\UserPasswordRequest::class,
        Contracts\UserForgotPasswordRequestContract::class => Requests\UserForgotPasswordRequest::class,
        Contracts\UserResetPasswordRequestContract::class => Requests\UserResetPasswordRequest::class,

        // Catalog
        Contracts\StoreUserProductReviewRequestContract::class => Requests\StoreUserProductReviewRequest::class,
        Contracts\StoreUserSubscribeRequestContract::class => Requests\StoreUserSubscribeRequest::class,

        // Cart
        Contracts\UserAddToCartRequestContract::class => Requests\UserAddToCartRequest::class,

        // Order
        Contracts\UserOrderRequestContract::class => Requests\UserOrderRequest::class,

        // Address
        Contracts\StoreUserAddressRequestContract::class => Requests\StoreUserAddressRequest::class,
    ];
}
