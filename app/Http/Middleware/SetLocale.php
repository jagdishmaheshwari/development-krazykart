<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle($request, Closure $next)
    // {
    //     prd(Session::all());
    //     pr(App::getLocale());
    //     if (Session::has('applocale')) {
    //         App::setLocale(Session::get('applocale'));
    //     }
    //     prd(App::getLocale());

    //     return $next($request);
    // }
}
