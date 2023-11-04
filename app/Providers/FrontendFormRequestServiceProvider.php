<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Contracts\Requests\Frontend as Contracts;
use App\Http\Requests\Frontend as Requests;

class FrontendFormRequestServiceProvider extends ServiceProvider
{
    public $singletons = [
        Contracts\UserSignupRequestContract::class => Requests\UserSignupRequest::class,
        Contracts\UserSigninRequestContract::class => Requests\UserSigninRequest::class,

        Contracts\StoreUserProductReviewRequestContract::class => Requests\StoreUserProductReviewRequest::class,
        Contracts\StoreUserSubscribeRequestContract::class => Requests\StoreUserSubscribeRequest::class,
    ];
}
