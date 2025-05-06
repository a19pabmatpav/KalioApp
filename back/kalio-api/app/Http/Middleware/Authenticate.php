<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // Evita redirección, lanza error 401 si no es JSON
        if (! $request->expectsJson()) {
            abort(401, 'Unauthorized');
        }
    }
}
