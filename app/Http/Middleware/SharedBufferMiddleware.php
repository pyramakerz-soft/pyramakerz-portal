<?php

namespace App\Http\Middleware;

use Closure;

class SharedBufferMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');
        $response->headers->set('Cross-Origin-Resource-Policy', 'cross-origin');
        return $response;
    }
}
