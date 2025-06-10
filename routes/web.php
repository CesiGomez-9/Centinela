<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [ServicioController::class, 'index'])->name('servicios.index');
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');



Route::get('/catalogo', [ServicioController::class, 'catalogo'])->name('servicios.catalogo');
