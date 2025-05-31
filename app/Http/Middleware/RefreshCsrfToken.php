<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RefreshCsrfToken
{
    public function handle(Request $request, Closure $next)
    {
        // Rafraîchir le token CSRF toutes les 30 minutes
        if (Session::has('_token')) {
            $token = Session::token();
            Session::put('_token', $token);
        }

        return $next($request);
    }
} 