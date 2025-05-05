<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\TrackVisitor;

class Kernel extends HttpKernel
{
    /**
     * Les piles de middleware globales HTTP de l'application.
     *
     * @var array
     */
    protected $middleware = [
        // Middleware global
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\LoadMigrationsFrom::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        // Ajoutez ici d'autres middlewares si nécessaire
        TrackVisitor::class,  // Ajout du middleware pour suivre les visiteurs
    ];

    /**
     * Les groupes de middleware de routes de l'application.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Les middleware de routes de l'application.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Vous pouvez ajouter des middleware spécifiques à certaines routes ici
    ];
}
