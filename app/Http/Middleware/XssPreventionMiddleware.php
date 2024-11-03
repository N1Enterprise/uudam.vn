<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use voku\helper\AntiXSS;

class XssPreventionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        $antiXss = new AntiXSS();

        $ignoreParams = config('security.xss_prevention.ignore_params', []);

        array_walk_recursive($input, function (&$input, $key) use ($antiXss, $ignoreParams) {
            if (! empty($input)) {
                if (! in_array($key, $ignoreParams)) {
                    $input = $antiXss->xss_clean($input);
                }
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
