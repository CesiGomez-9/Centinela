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
Route::put('empleados/{empleado}', [EmpleadoController::class, 'update'])->name('empleados.update');


Route::get('/facturas_ventas', [\App\Http\Controllers\FacturaVentaController::class, 'index'])->name('facturas_ventas.index');
Route::get('/facturas_ventas/create', [\App\Http\Controllers\FacturaVentaController::class, 'create'])->name('facturas_ventas.create');
Route::post('/facturas_ventas', [\App\Http\Controllers\FacturaVentaController::class, 'store'])->name('facturas_ventas.store');
Route::get('/facturas_ventas/{factura_venta}', [\App\Http\Controllers\FacturaVentaController::class, 'show'])->name('facturas_ventas.show');
Route::get('/facturas_ventas/{factura_venta}/edit', [\App\Http\Controllers\FacturaVentaController::class, 'edit'])->name('facturas_ventas.edit');
Route::put('/facturas_ventas/{factura_venta}', [\App\Http\Controllers\FacturaVentaController::class, 'update'])->name('facturas_ventas.update');



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


