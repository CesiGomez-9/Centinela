<?php

use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FacturaCompraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TurnoController;
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


Route::get('/facturas_ventas', [\App\Http\Controllers\FacturaVentaController::class, 'index'])->name('facturas_ventas.index');
Route::get('/facturas_ventas/create', [\App\Http\Controllers\FacturaVentaController::class, 'create'])->name('facturas_ventas.create');
Route::post('/facturas_ventas', [\App\Http\Controllers\FacturaVentaController::class, 'store'])->name('facturas_ventas.store');
Route::get('/facturas_ventas/{factura_venta}', [\App\Http\Controllers\FacturaVentaController::class, 'show'])->name('facturas_ventas.show');
Route::get('/facturas_ventas/{factura_venta}/edit', [\App\Http\Controllers\FacturaVentaController::class, 'edit'])->name('facturas_ventas.edit');
Route::put('/facturas_ventas/{factura_venta}', [\App\Http\Controllers\FacturaVentaController::class, 'update'])->name('facturas_ventas.update');

Route::get('/clientes/buscar', [App\Http\Controllers\ClienteController::class, 'buscar'])->name('clientes.buscar');



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
Route::get('/servicios/{servicio}', [ServicioController::class, 'show'])->name('servicios.show');
Route::get('/servicios/{servicio}/edit', [ServicioController::class, 'edit'])->name('servicios.edit');
Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');

Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.create');
Route::post('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'store'])->name('Proveedores.store');
Route::get('/Proveedores', [\App\Http\Controllers\ProveedorController::class, 'index'])->name('Proveedores.indexProveedor');
Route::get('/Proveedores/crear', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('Proveedores.nuevo');
Route::get('/Proveedores/{id}', [ProveedorController::class, 'show'])->name('Proveedores.detalle')->whereNumber('id');


Route::controller(FacturaCompraController::class)->group(function () {
    Route::get('/facturas_compras', 'index')->name('facturas_compras.index');
    Route::get('/facturas_compras/{id}', 'show')->name('facturas_compras.show')->whereNumber('id');
    Route::get('/facturas_compras/crear', 'create')->name('facturas_compras.create');
    Route::post('/facturas_compras/crear', 'store')->name('facturas_compras.store');
    Route::get('/facturas_compras/{id}/editar', 'edit')->name('facturas_compras.edit')->whereNumber('id');
    Route::put('/facturas_compras/{id}/editar', 'update')->name('facturas_compras.update')->whereNumber('id');
});

Route::controller(TurnoController::class)->group(function () {
    Route::get('/turnos', 'index')->name('turnos.index');
    Route::get('/turnos/{id}', 'show')->name('turnos.show')->whereNumber('id');
    Route::get('/turnos/crear', 'create')->name('turnos.create');
    Route::post('/turnos/crear', 'store')->name('turnos.store');
    Route::get('/turnos/empleados-por-servicio/{servicio_id}', [TurnoController::class, 'getEmpleadosPorServicio'])->name('turnos.empleadosPorServicio');
    Route::get('/turnos/{id}/editar', 'edit')->name('turnos.edit')->whereNumber('id');
    Route::put('/turnos/{id}/editar', 'update')->name('turnos.update')->whereNumber('id');
});


Route::get('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'create'])->name('Clientes.create');
Route::post('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'store'])->name('Clientes.store');
Route::get('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'create'])->name('Clientes.formulariocliente');
Route::get('/Clientes', [\App\Http\Controllers\ClienteController::class, 'index'])->name('Clientes.indexCliente');
Route::get('/Clientes/{id}', [\App\Http\Controllers\ClienteController::class, 'show'])->name('Clientes.detalleCliente')->whereNumber('id');

Route::get('/instalaciones/formulario', [\App\Http\Controllers\InstalacionController::class, 'create'])->name('instalaciones.formulario');
Route::post('/instalaciones', [\App\Http\Controllers\InstalacionController::class, 'store'])->name('instalaciones.store');
Route::get('/instalaciones', [\App\Http\Controllers\InstalacionController::class, 'index'])->name('instalaciones.index');
// routes/web.php
Route::get('/instalaciones/eventos', [\App\Http\Controllers\InstalacionController::class, 'eventos'])->name('instalaciones.eventos');
