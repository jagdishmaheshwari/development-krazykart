<?php

// app/Http/Middleware/AuthenticateMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if user is not authenticated
        }

        return $next($request);
    }
}
