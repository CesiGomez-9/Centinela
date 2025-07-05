<?php

use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('empleados.index');
});

Route::get('/', function () {
    return view('index');

});


Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
Route::resource('empleados', EmpleadoController::class);

Route::get('/Proveedores/crear', [ProveedorController::class, 'create'])->name('Proveedores.create');
Route::post('/Proveedores/crear', [ProveedorController::class, 'store'])->name('Proveedores.store');
Route::get('/Proveedores', [ProveedorController::class, 'index'])->name('Proveedores.indexProveedor');
Route::get('/Proveedores/crear', [ProveedorController::class, 'create'])->name('Proveedores.nuevo');
Route::get('/Proveedores/{id}', [ProveedorController::class, 'show'])->name('Proveedores.detalle')->whereNumber('id');
Route::get('/Proveedores/{id}/editar', [ProveedorController::class, 'edit'])->name('Proveedores.edit');
Route::put('/Proveedores/{id}', [ProveedorController::class, 'update'])->name('Proveedores.update');




Route::controller(ProductoController::class)->group(function () {
    Route::get('/productos', 'index')->name('productos.index');
    Route::get('/productos/{id}', 'show')->name('productos.show')->whereNumber('id');
    Route::get('/productos/crear', 'create')->name('productos.create');
    Route::post('/productos/crear', 'store')->name('productos.store');


    Route::get('/productos/{id}/editar', 'edit')->name('productos.edit')->whereNumber('id');
    Route::put('/productos/{id}/editar', 'update')->name('productos.update')->whereNumber('id');
});



Route::get('/servicios/index', [ServicioController::class, 'index'])->name('servicios.index');
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
Route::get('/catalogo', [ServicioController::class, 'catalogo'])->name('servicios.catalogo');



Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.create');
Route::post('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'store'])->name('Proveedores.store');
Route::get('/Proveedores', [\App\Http\Controllers\ProveedorController::class, 'index'])->name('Proveedores.indexProveedor');
Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.nuevo');
Route::get('/Proveedores/{id}', [ProveedorController::class, 'show'])->name('Proveedores.detalle')->whereNumber('id');


Route::controller(FacturaController::class)->group(function () {
    Route::get('/facturas', 'index')->name('facturas.index');
    Route::get('/facturas/{id}', 'show')->name('facturas.show')->whereNumber('id');
    Route::get('/facturas/crear', 'create')->name('facturas.create');
    Route::post('/facturas/crear', 'store')->name('facturas.store');


    Route::get('/facturas/{id}/editar', 'edit')->name('facturas.edit')->whereNumber('id');
    Route::put('/facturas/{id}/editar', 'update')->name('facturas.update')->whereNumber('id');
});


