<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StudentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student-login')->withErrors(['message' => 'Please log in first.']);
        }

        return $next($request);
    }
}

