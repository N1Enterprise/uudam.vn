<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Common\RequestHelper;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (RequestHelper::isFrontEndRequest($request)) {
                return route('fe.web.home', ['overlay' => 'signin', 'redirect' => $request->fullUrl()]);
            } else if (RequestHelper::isBackOfficeRequest($request)) {
                return route('login');
            }
        }
    }
}
