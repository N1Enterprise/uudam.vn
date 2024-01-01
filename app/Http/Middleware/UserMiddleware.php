<?php

namespace App\Http\Middleware;

use App\Classes\Contracts\UserAuthContract;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = app(UserAuthContract::class)->user();

        if (! $user) {
            return $next($request);
        }

        if (! $user->isActive()) {
            throw new BusinessLogicException('Your account has been deactivated.', ExceptionCode::DEACTIVATED_ACCOUNT, 401);
        }

        return $next($request);
    }
}
