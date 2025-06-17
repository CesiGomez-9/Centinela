<?php

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\InventarioController;
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

Route::controller(InventarioController::class)->group(function (){
    Route::get('/inventarios', 'index')->name('inventarios.index');
    Route::get('/inventarios/{id}', 'show')->name('inventarios.show')->whereNumber('id');
    Route::get('/inventarios/crear', 'create')->name('inventarios.create');
    Route::post('/inventarios/crear', 'store')->name('inventarios.store');
});

Route::get('/servicios/index', [ServicioController::class, 'index'])->name('servicios.index');
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
Route::get('/catalogo', [ServicioController::class, 'catalogo'])->name('servicios.catalogo');



Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.create');
Route::post('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'store'])->name('Proveedores.store');
Route::get('/Proveedores', [\App\Http\Controllers\ProveedorController::class, 'index'])->name('Proveedores.indexProveedor');
Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.nuevo');

