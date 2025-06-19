<?php

use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('empleados.index');
});


Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
Route::get('/empleados/{id}', [EmpleadoController::class, 'show'])->name('empleados.show');
Route::resource('empleados', EmpleadoController::class)->except(['index', 'show']);


Route::controller(InventarioController::class)->group(function () {
    Route::get('/inventarios', 'index')->name('inventarios.index');
    Route::get('/inventarios/{id}', 'show')->name('inventarios.show')->whereNumber('id');
    Route::get('/inventarios/crear', 'create')->name('inventarios.create'); /*->middleware('auth');*/
    Route::post('/inventarios/crear', 'store')->name('inventarios.store'); #->middleware('auth');
    /*Route::get('/inventarios/{id}/editar', 'edit')->name('inventarios.edit')->whereNumber('id'); #->middleware('auth');
    Route::put('/inventarios/{id}/editar', 'update')->name('inventarios.update')->whereNumber('id'); #->middleware('auth');
    Route::delete('/inventarios/{id}/eliminar', 'destroy')->name('inventarios.destroy')->whereNumber('id'); #->middleware('auth');
    */
});
Route::controller(InventarioController::class)->group(function () {
    Route::get('/inventarios', 'index')->name('inventarios.index');
    Route::get('/inventarios/{id}', 'show')->name('inventarios.show')->whereNumber('id');
    Route::get('/inventarios/crear', 'create')->name('inventarios.create'); /*->middleware('auth');*/
    Route::post('/inventarios/crear', 'store')->name('inventarios.store'); #->middleware('auth');
    /*Route::get('/inventarios/{id}/editar', 'edit')->name('inventarios.edit')->whereNumber('id'); #->middleware('auth');
    Route::put('/inventarios/{id}/editar', 'update')->name('inventarios.update')->whereNumber('id'); #->middleware('auth');
    Route::delete('/inventarios/{id}/eliminar', 'destroy')->name('inventarios.destroy')->whereNumber('id'); #->middleware('auth');
    */
});

Route::get('/', [ServicioController::class, 'index'])->name('servicios.index');
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
Route::get('/catalogo', [ServicioController::class, 'catalogo'])->name('servicios.catalogo');
