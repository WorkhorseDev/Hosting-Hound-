<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'twofactor' => \App\Http\Middleware\TwoFactorMiddleware::class,
    ];
}
