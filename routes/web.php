<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('index');
});

Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.create');
Route::post('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'store'])->name('Proveedores.store');
Route::get('/Proveedores', [\App\Http\Controllers\ProveedorController::class, 'index'])->name('Proveedores.indexProveedor');
Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.nuevo');
