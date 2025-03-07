<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToRoot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $enableForceHttps = boolean(env('app.enable_force_https'));

        // Check if the request is not already using HTTPS and redirect if not
        if (! $request->secure() && $enableForceHttps) {
            return redirect()->secure($request->getRequestUri());
        }

        $host = $request->getHost();

        // Check if the request URI starts with '/public' and redirect to root if so
        if (strpos($request->getRequestUri(), '/public') === 0) {
            $newUrl = str_replace($host . '/' . 'public', $host, $request->url());
            return redirect($newUrl);
        }

        return $next($request);
    }
}
