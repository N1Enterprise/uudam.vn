<?php

namespace App\Providers;

use App\Http\Responses\Frontend as Responses;
use App\Contracts\Responses\Frontend as Contracts;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class FrontendResponseServiceProvider extends ServiceProvider
{
    public $singletons = [
        Contracts\SignupResponseContract::class => Responses\SignupResponse::class,
        Contracts\SigninResponseContract::class => Responses\SigninResponse::class,
    ];
}
