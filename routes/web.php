<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ProductoController;

Route::controller(ProductoController::class)->group(function () {
    Route::get('/productos', 'index')->name('productos.index');
    Route::get('/productos/{id}', 'show')->name('productos.show')->whereNumber('id');
    Route::get('/productos/crear', 'create')->name('productos.create');
    Route::post('/productos/crear', 'store')->name('productos.store');

    #Route::get('/productos/{id}/editar', 'edit')->name('productos.edit')->whereNumber('id');
    #Route::put('/productos/{id}/editar', 'update')->name('productos.update')->whereNumber('id');

});

