<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Obtener la URL a donde redirigir cuando el usuario no está autenticado.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            //return route('login');
            abort(401, 'No autenticado.');
        }
    }
}