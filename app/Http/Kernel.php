<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {
    protected $middlewareGroups = [
    'web' => [
        // ... other middleware ...
        \App\Http\Middleware\VerifyCsrfToken::class,
    ],

    'api' => [
        // ... other middleware ...
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
}