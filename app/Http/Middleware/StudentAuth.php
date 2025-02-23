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
    public function handle(Request $request, Closure $next)
    {
        // Prevent infinite redirect loop by allowing access to admin login page
        if ($request->route()->getName() === 'student-login') {
            return $next($request);
        }

        // Redirect if the user is NOT logged in as an admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('student-login');
        }

        return $next($request);
    }
}

