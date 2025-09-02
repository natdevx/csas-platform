<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Soporte para múltiples roles separados por "|"
        $roles = explode('|', $roles);

        if (!in_array($user->role, $roles)) {
            return response()->json(['error' => 'No tienes permiso'], 403);
        }

        return $next($request);
    }
}
