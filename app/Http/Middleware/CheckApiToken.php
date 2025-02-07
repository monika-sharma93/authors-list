<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow access to the login page without checking the token
        if ($request->is('login')) {
            return $next($request);
        }

        // Check if the API token exists in the session
        if (!Session::has('access_token')) {
            return redirect('/login')->with('error', 'You must log in first.');
        }

        return $next($request);
    }
}
