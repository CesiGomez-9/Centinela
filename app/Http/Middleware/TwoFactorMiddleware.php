<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // No interceptar rutas de 2FA ni logout
        if ($request->routeIs('two-factor.*') || $request->routeIs('logout')) {
            return $next($request);
        }

        // Si hay verificación 2FA pendiente, redirigir a verificar
        if (session('two_factor_pending_user')) {
            Auth::logout();
            return redirect()->route('login');
        }

        // Si tiene 2FA activo y la sesión actual no está verificada
        if ($user->hasTwoFactorEnabled() && !session('two_factor_verified')) {
            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('login')
                ->withErrors(['usuario' => 'Se requiere verificación de dos factores.']);
        }

        // Si el rol requiere 2FA pero no lo tiene configurado, forzar setup
        if ($user->requiresTwoFactor() && !$user->hasTwoFactorEnabled()) {
            return redirect()->route('two-factor.setup')
                ->with('warning', 'Tu rol requiere configurar la autenticación de dos factores para continuar.');
        }

        return $next($request);
    }
}
