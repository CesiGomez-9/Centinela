<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\InventarioController;

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

