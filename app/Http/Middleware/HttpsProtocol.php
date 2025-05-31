<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsProtocol
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->secure() && app()->environment('production')) {
            // Get the full URL including query parameters
            $url = $request->getRequestUri();
            
            // Ensure we're redirecting to HTTPS
            return redirect()->secure($url, 301);
        }

        return $next($request);
    }
} 