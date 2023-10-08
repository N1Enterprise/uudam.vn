<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Contracts\Requests\Frontend as Contracts;
use App\Http\Requests\Frontend as Requests;

class FrontendFormRequestServiceProvider extends ServiceProvider
{
    public $singletons = [

    ];
}
