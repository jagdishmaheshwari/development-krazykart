<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check()) {
            // User is authenticated
            return $next($request);
        } elseif (Auth::guard('admin')->check()) {
            // Admin is authenticated
            return $next($request);
        } else {
            // Neither user nor admin is authenticated
            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect()->route('admin.login');
            } else {
                return redirect()->route('login');
            }
        }
    }
}
