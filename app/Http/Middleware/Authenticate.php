<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {

            abort(response()->json([

                'message' => 'Não autenticado.',
            ], 401));
        }

        abort(401, 'Não autenticado.');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }
}
