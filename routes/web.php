<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;




Route::get('/servicios/index', [ServicioController::class, 'index'])->name('servicios.index');
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
Route::get('/catalogo', [ServicioController::class, 'catalogo'])->name('servicios.catalogo');
Route::get('servicios/{id}', [ServicioController::class, 'show'])->name('servicios.show');
Route::get('servicios/{id}/edit', [ServicioController::class, 'edit'])->name('servicios.edit');
Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');



Route::get('/', function () {
    return redirect()->route('empleados.index');
});

Route::get('/', function () {
    return view('index');

});


Route::get('/empleados', [\App\Http\Controllers\EmpleadoController::class, 'index'])->name('empleados.index');
Route::post('/empleados', [\App\Http\Controllers\EmpleadoController::class, 'store'])->name('empleados.store');
Route::get('/empleados/create', [\App\Http\Controllers\EmpleadoController::class, 'create'])->name('empleados.create');
Route::resource('empleados', \App\Http\Controllers\EmpleadoController::class);


Route::get('/facturas_ventas', [\App\Http\Controllers\FacturaVentaController::class, 'index'])->name('facturas_ventas.index');
Route::get('/facturas_ventas/create', [\App\Http\Controllers\FacturaVentaController::class, 'create'])->name('facturas_ventas.create');
Route::post('/facturas_ventas', [\App\Http\Controllers\FacturaVentaController::class, 'store'])->name('facturas_ventas.store');
Route::get('/facturas_ventas/{factura_venta}', [\App\Http\Controllers\FacturaVentaController::class, 'show'])->name('facturas_ventas.show');
Route::get('/facturas_ventas/{factura_venta}/edit', [\App\Http\Controllers\FacturaVentaController::class, 'edit'])->name('facturas_ventas.edit');
Route::put('/facturas_ventas/{factura_venta}', [\App\Http\Controllers\FacturaVentaController::class, 'update'])->name('facturas_ventas.update');





Route::get('/Proveedores/crear', [\App\Http\Controllers\ProductoController::class, 'create'])->name('Proveedores.create');


Route::post('/Proveedores/crear', [\App\Http\Controllers\ProductoController::class, 'store'])->name('Proveedores.store');
Route::get('/Proveedores', [\App\Http\Controllers\ProductoController::class, 'index'])->name('Proveedores.indexProveedor');
Route::get('/Proveedores/crear', [\App\Http\Controllers\ProductoController::class, 'create'])->name('Proveedores.nuevo');
Route::get('/Proveedores/{id}', [ProveedorController::class, 'show'])->name('Proveedores.detalle')->whereNumber('id');
Route::get('/Proveedores/{id}/editar', [ProveedorController::class, 'edit'])->name('Proveedores.edit');
Route::put('/Proveedores/{id}', [ProveedorController::class, 'update'])->name('Proveedores.update');




Route::controller(\App\Http\Controllers\ProductoController::class)->group(function () {
    Route::get('/productos', 'index')->name('productos.index');
    Route::get('/productos/{id}', 'show')->name('productos.show')->whereNumber('id');
    Route::get('/productos/crear', 'create')->name('productos.create');
    Route::post('/productos/crear', 'store')->name('productos.store');


    Route::get('/productos/{id}/editar', 'edit')->name('productos.edit')->whereNumber('id');
    Route::put('/productos/{id}/editar', 'update')->name('productos.update')->whereNumber('id');
});




Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.create');
Route::post('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'store'])->name('Proveedores.store');
Route::get('/Proveedores', [\App\Http\Controllers\ProveedorController::class, 'index'])->name('Proveedores.indexProveedor');
Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.nuevo');
Route::get('/Proveedores/{id}', [ProveedorController::class, 'show'])->name('Proveedores.detalle')->whereNumber('id');


Route::controller(\App\Http\Controllers\FacturaController::class)->group(function () {
    Route::get('/facturas', 'index')->name('facturas.index');
    Route::get('/facturas/{id}', 'show')->name('facturas.show')->whereNumber('id');
    Route::get('/facturas/crear', 'create')->name('facturas.create');
    Route::post('/facturas/crear', 'store')->name('facturas.store');


    Route::get('/facturas/{id}/editar', 'edit')->name('facturas.edit')->whereNumber('id');
    Route::put('/facturas/{id}/editar', 'update')->name('facturas.update')->whereNumber('id');
});

Route::get('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'create'])->name('Clientes.create');
Route::post('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'store'])->name('Clientes.store');
Route::get('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'create'])->name('Clientes.formulariocliente');
Route::get('/Clientes', [\App\Http\Controllers\ClienteController::class, 'index'])->name('Clientes.indexCliente');

