<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'dashboard/produits/*',
        'checkout/*',
        'api/checkout/*',
        'checkout/process',
        'checkout/validate',
        'checkout/payment',
        'api/*',
        'webhook/*',
        'payment/*',
        'payment/process',
        'payment/validate',
        'payment/callback',
        'payment/success',
        'payment/fail'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // Add CSRF token to response headers for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            $response = $next($request);
            $response->headers->set('X-CSRF-TOKEN', csrf_token());
            return $response;
        }

        try {
            return parent::handle($request, $next);
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Session expirée. Veuillez rafraîchir la page.',
                    'csrf_token' => csrf_token()
                ], 419);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Votre session a expiré. Veuillez rafraîchir la page et réessayer.'])
                ->with('csrf_token', csrf_token());
        }
    }
} 