<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd([

            'session_data' => session()->all(),
            'user' => auth()->user(),
            'auth_check' => auth()->check(),
            'session_id' => session()->getId()
        ]);

        return $next($request);
    }
}
