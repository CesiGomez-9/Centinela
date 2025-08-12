<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoApiController; // Importa el controlador API
use App\Models\Instalacion;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta para obtener productos desde la API
Route::get('/productos', [ProductoApiController::class, 'index']);

Route::get('/tecnicos-ocupados', function (Request $request) {
    $ocupados = Instalacion::whereDate('fecha_instalacion', $request->fecha)
        ->with('tecnicos')
        ->get()
        ->flatMap(fn($i) => $i->tecnicos->pluck('id'))
        ->unique()
        ->values();

    return response()->json($ocupados);
});

