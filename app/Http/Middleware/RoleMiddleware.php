<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Usuario no autenticado
        if (!auth()->check()) {
            abort(403, 'Debes iniciar sesión.');
        }

        // Verificar rol del usuario
        if (auth()->user()->rol !== $role) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
