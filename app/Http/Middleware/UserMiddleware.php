<?php

namespace App\Http\Middleware;

use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $player = app(PlayerAuthContract::class)->user();

        if (! $player) {
            return $next($request);
        }

        if (! $player->isActive()) {
            throw new BusinessLogicException('Your account has been deactivated.', ExceptionCode::DEACTIVATED_ACCOUNT, 401);
        }

        return $next($request);
    }
}
