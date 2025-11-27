<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; // Importar la fachada Route
use Illuminate\Cache\RateLimiting\Limit; // Importar Limit para rate limiting
use Illuminate\Support\Facades\RateLimiter; // Importar RateLimiter
use Illuminate\Http\Request; // Importar Request para rate limiting
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */



    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // --- INICIO: Lógica para cargar rutas API y Web ---
        // Esta lógica normalmente estaría en RouteServiceProvider.php
        // pero la añadimos aquí si RouteServiceProvider no existe.

        // Configuración del rate limiting para la API (opcional, pero buena práctica)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Cargar las rutas de la API
        Route::middleware('api')
            ->prefix('api') // Todas las rutas en api.php tendrán el prefijo /api/
            ->group(base_path('routes/api.php'));

        // Cargar las rutas web
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // --- FIN: Lógica para cargar rutas API y Web ---
    }
}
