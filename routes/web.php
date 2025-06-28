<?php

use App\Http\Controllers\FacturaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('index');

});



Route::controller(ProductoController::class)->group(function () {
    Route::get('/productos', 'index')->name('productos.index');
    Route::get('/productos/{id}', 'show')->name('productos.show')->whereNumber('id');
    Route::get('/productos/crear', 'create')->name('productos.create');
    Route::post('/productos/crear', 'store')->name('productos.store');

    #Route::get('/productos/{id}/editar', 'edit')->name('productos.edit')->whereNumber('id');
    #Route::put('/productos/{id}/editar', 'update')->name('productos.update')->whereNumber('id');

});

Route::controller(FacturaController::class)->group(function () {
    Route::get('/facturas', 'index')->name('facturas.index');
    Route::get('/facturas/{id}', 'show')->name('facturas.show')->whereNumber('id');
    Route::get('/facturas/crear', 'create')->name('facturas.create');
    Route::post('/facturas/crear', 'store')->name('facturas.store');

    // Ruta para autocompletar productos según proveedor
    Route::get('/facturas/proveedor/{nombre}/productos', 'obtenerProductosProveedor')
        ->name('facturas.proveedor.productos');

    #Route::get('/facturas/{id}/editar', 'edit')->name('facturas.edit')->whereNumber('id');
    #Route::put('/facturas/{id}/editar', 'update')->name('facturas.update')->whereNumber('id');

});

