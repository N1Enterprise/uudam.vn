<?php

namespace App\Http\Middleware;

use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthentiateProviderCallbackIPsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $providerCallbackIPs = collect(SystemSetting::from(SystemSettingKeyEnum::PROVIDER_CALLBACK_WHITELIST_IPS)->get(null, []))->flatMap(function ($ips) {
            return $ips;
        })->toArray();

        $ip = $request->ip();
        $isEnvNeedAuthenticate = app()->environment('production') || app()->environment('development');

        if (
            ! in_array($ip, $providerCallbackIPs)
            && $isEnvNeedAuthenticate
        ) {
            return response([ 'Error' => 'Forbidden' ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
