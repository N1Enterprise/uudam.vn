<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToggleFeatureMiddleware
{
    public function handle(Request $request, Closure $next , $key = null )
    {
        $featureEnabled = SystemSetting::from($key)->get();

        if (! $featureEnabled){
            return response([], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
