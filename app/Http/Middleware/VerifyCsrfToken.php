<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'stripe/*',
    ];

    public function handle($request, \Closure $next)
    {
        // It skips the CSRF Token validation
        if (in_array(env('APP_ENV'), ['local', 'dev', 'development', 'staging'])) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
