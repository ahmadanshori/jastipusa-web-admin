<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force HTTPS if configured to do so and request is not already secure
        if ((config('app.force_https', false) || config('app.env') === 'production') && !$request->secure()) {
            // Redirect to HTTPS version
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
