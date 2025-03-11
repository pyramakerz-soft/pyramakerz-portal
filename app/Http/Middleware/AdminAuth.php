<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Prevent infinite redirect loop by allowing access to admin login page
        if ($request->route()->getName() === 'admin-login') {
            return $next($request);
        }

        // Redirect if the user is NOT logged in as an admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin-login');
        }

        return $next($request);
    }
}
