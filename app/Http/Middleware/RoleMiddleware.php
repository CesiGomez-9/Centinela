<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    protected $routeMiddleware = [
        // otros middlewares
        'role' => \App\Http\Middleware\CheckRole::class,
    ];

    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si no está logeado
        if (!auth()->check()) {
            abort(403, 'Debes iniciar sesión.');
        }

        // Si el rol del usuario no está dentro de la lista permitida
        if (!in_array(auth()->user()->rol, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
