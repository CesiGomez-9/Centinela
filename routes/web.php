<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\InventarioController;

Route::controller(InventarioController::class)->group(function () {
    Route::get('/inventarios', 'index')->name('inventarios.index');
    Route::get('/inventarios/{id}', 'show')->name('inventarios.show')->whereNumber('id');
    Route::get('/inventarios/crear', 'create')->name('inventarios.create');
    Route::post('/inventarios/crear', 'store')->name('inventarios.store');

    #Route::get('/inventarios/{id}/editar', 'edit')->name('inventarios.edit')->whereNumber('id');
    #Route::put('/inventarios/{id}/editar', 'update')->name('inventarios.update')->whereNumber('id');

});

