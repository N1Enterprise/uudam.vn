<?php

namespace App\Http\Middleware;

use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MaintenanceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $isMaintenance = SystemSetting::from(SystemSettingKeyEnum::IS_MAINTENANCE)->get();

        $route = Route::getRoutes()->match($request);

        if ($isMaintenance && $route->getName() == 'fe.web.maintenance') {
            return $next($request);
        }

        if ($isMaintenance) {
            return redirect()->route('fe.web.maintenance');
        }

        if (! $isMaintenance && $route->getName() == 'fe.web.maintenance') {
            return redirect()->route('fe.web.home');
        }

        return $next($request);
    }
}
