<?php

use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FacturaCompraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\TurnoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CapacitacionController;

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Rutas de 2FA (verificación durante login — sin auth)
Route::get('/two-factor/verify', [\App\Http\Controllers\TwoFactorController::class, 'showVerify'])->name('two-factor.verify');
Route::post('/two-factor/verify', [\App\Http\Controllers\TwoFactorController::class, 'verify'])->name('two-factor.verify.post');

Route::get('/forgotpassword', [\App\Http\Controllers\PasswordResetController::class, 'showLinkForm'])->name('password.request');
Route::post('/forgotpassword', [\App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/resetpassword/{token}', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/resetpassword', [\App\Http\Controllers\PasswordResetController::class, 'resetPassword'])->name('password.update');


// Rutas protegidas (requieren autenticación + 2FA)
Route::middleware(['auth', 'two-factor'])->group(function () {

    Route::get('/index', function () {
        return view('index');
    })->name('index');

    Route::get('/quienes_somos', function () { return view('quienes_somos'); })->name('quienes_somos');

    // Dashboard según rol
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // AJAX (sin restricción de permiso específico, solo auth)
    Route::get('ajax/empleados', [UserController::class, 'searchEmpleados'])->name('ajax.empleados');
    Route::get('/ajax/check-user/{empleado}', [UserController::class, 'checkUser']);

    // Empleados
    Route::get('/buscar-empleados', [EmpleadoController::class, 'buscar'])->middleware('permission:listado de empleados')->name('empleados.buscar');
    Route::get('/empleados', [EmpleadoController::class, 'index'])->middleware('permission:listado de empleados')->name('empleados.index');
    Route::get('/empleados/create', [EmpleadoController::class, 'create'])->middleware('permission:registrar empleados')->name('empleados.create');
    Route::post('/empleados', [EmpleadoController::class, 'store'])->middleware('permission:registrar empleados')->name('empleados.store');
    Route::get('/empleados/{empleado}', [EmpleadoController::class, 'show'])->middleware('permission:ver empleados')->name('empleados.show');
    Route::get('/empleados/{empleado}/edit', [EmpleadoController::class, 'edit'])->middleware('permission:editar empleados')->name('empleados.edit');
    Route::put('/empleados/{empleado}', [EmpleadoController::class, 'update'])->middleware('permission:editar empleados')->name('empleados.update');
    Route::patch('/empleados/{empleado}', [EmpleadoController::class, 'update'])->middleware('permission:editar empleados');
    Route::delete('/empleados/{empleado}', [EmpleadoController::class, 'destroy'])->middleware('permission:editar empleados')->name('empleados.destroy');

    // Facturas de venta
    Route::middleware('permission:listado de factura de venta|registrar factura de venta|ver factura de venta')->group(function () {
        Route::get('/facturas_ventas', [\App\Http\Controllers\FacturaVentaController::class, 'index'])->name('facturas_ventas.index');
        Route::get('/facturas_ventas/create', [\App\Http\Controllers\FacturaVentaController::class, 'create'])->name('facturas_ventas.create');
        Route::post('/facturas_ventas', [\App\Http\Controllers\FacturaVentaController::class, 'store'])->name('facturas_ventas.store');
        Route::get('/facturas_ventas/{factura_venta}', [\App\Http\Controllers\FacturaVentaController::class, 'show'])->name('facturas_ventas.show');
        Route::get('/facturas_ventas/{factura_venta}/edit', [\App\Http\Controllers\FacturaVentaController::class, 'edit'])->name('facturas_ventas.edit');
        Route::put('/facturas_ventas/{factura_venta}', [\App\Http\Controllers\FacturaVentaController::class, 'update'])->name('facturas_ventas.update');
    });

    // Memorandos
    Route::middleware('permission:listado de memorándum|registrar memorándum|ver memorándum')->group(function () {
        Route::resource('memorandos', \App\Http\Controllers\MemorandoController::class);
        Route::get('memorando/adjunto/{filename}', [\App\Http\Controllers\MemorandoController::class, 'descargarAdjunto'])->name('memorando.adjunto');
    });

    // Promociones
    Route::middleware('permission:listado de promociones|registrar promociones')->group(function () {
        Route::resource('promociones', \App\Http\Controllers\PromocionController::class);
        Route::get('/promociones/{promocion}/show', [PromocionController::class, 'show'])->name('promociones.show');
    });

    // Incapacidades
    Route::get('/incapacidades', [\App\Http\Controllers\IncapacidadController::class, 'index'])->middleware('permission:listado de incapacidad')->name('incapacidades.index');
    Route::get('/incapacidades/create', [\App\Http\Controllers\IncapacidadController::class, 'create'])->middleware('permission:registrar incapacidad')->name('incapacidades.create');
    Route::post('/incapacidades', [\App\Http\Controllers\IncapacidadController::class, 'store'])->middleware('permission:registrar incapacidad')->name('incapacidades.store');
    Route::get('/incapacidades/{incapacidad}', [\App\Http\Controllers\IncapacidadController::class, 'show'])->middleware('permission:ver incapacidad')->name('incapacidades.show');
    Route::get('/incapacidades/{incapacidad}/edit', [\App\Http\Controllers\IncapacidadController::class, 'edit'])->middleware('permission:editar incapacidad')->name('incapacidades.edit');
    Route::put('/incapacidades/{incapacidad}', [\App\Http\Controllers\IncapacidadController::class, 'update'])->middleware('permission:editar incapacidad')->name('incapacidades.update');
    Route::patch('/incapacidades/{incapacidad}', [\App\Http\Controllers\IncapacidadController::class, 'update'])->middleware('permission:editar incapacidad');
    Route::delete('/incapacidades/{incapacidad}', [\App\Http\Controllers\IncapacidadController::class, 'destroy'])->middleware('permission:editar incapacidad')->name('incapacidades.destroy');

    // Usuarios y Roles (solo super_admin)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::get('/users/{user}/permisos', [UserController::class, 'verpermisos'])->name('users.verpermisos');
    });

    // Proveedores
    Route::middleware('permission:listado de proveedores|registrar proveedor')->group(function () {
        Route::get('/Proveedores/crear', [ProveedorController::class, 'create'])->name('Proveedores.create');
        Route::get('/Proveedores/crear', [ProveedorController::class, 'create'])->name('Proveedores.nuevo');
        Route::post('/Proveedores/crear', [ProveedorController::class, 'store'])->name('Proveedores.store');
        Route::get('/Proveedores', [ProveedorController::class, 'index'])->name('Proveedores.indexProveedor');
        Route::get('/Proveedores/{id}', [ProveedorController::class, 'show'])->name('Proveedores.detalle')->whereNumber('id');
        Route::get('/Proveedores/{id}/editar', [ProveedorController::class, 'edit'])->name('Proveedores.edit');
        Route::put('/Proveedores/{id}', [ProveedorController::class, 'update'])->name('Proveedores.update');
    });

    // Productos
    Route::middleware('permission:listado de producto|registrar producto|inventario de producto')->group(function () {
        Route::controller(ProductoController::class)->group(function () {
            Route::get('/productos', 'index')->name('productos.index');
            Route::get('/productos/{id}', 'show')->name('productos.show')->whereNumber('id');
            Route::get('/productos/crear', 'create')->name('productos.create');
            Route::post('/productos/crear', 'store')->name('productos.store');
            Route::get('/productos/{id}/editar', 'edit')->name('productos.edit')->whereNumber('id');
            Route::put('/productos/{id}/editar', 'update')->name('productos.update')->whereNumber('id');
        });
    });

    // Servicios
    Route::get('/servicios/index', [ServicioController::class, 'index'])->middleware('permission:listado de servicio')->name('servicios.index');
    Route::get('/catalogo', [ServicioController::class, 'catalogo'])->middleware('permission:listado de servicio')->name('servicios.catalogo');
    Route::post('/servicios', [ServicioController::class, 'store'])->middleware('permission:registrar servicio')->name('servicios.store');
    Route::get('/servicios/{servicio}', [ServicioController::class, 'show'])->middleware('permission:ver servicio')->name('servicios.show');
    Route::get('/servicios/{servicio}/edit', [ServicioController::class, 'edit'])->middleware('permission:editar servicio')->name('servicios.edit');
    Route::put('/servicios/{id}', [ServicioController::class, 'update'])->middleware('permission:editar servicio')->name('servicios.update');
    Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->middleware('permission:editar servicio')->name('servicios.destroy');

    // Facturas de compra
    Route::middleware('permission:listado de factura de compra|registrar factura de compra|ver factura de compra')->group(function () {
        Route::controller(FacturaCompraController::class)->group(function () {
            Route::get('/facturas_compras', 'index')->name('facturas_compras.index');
            Route::get('/facturas_compras/{id}', 'show')->name('facturas_compras.show')->whereNumber('id');
            Route::get('/facturas_compras/crear', 'create')->name('facturas_compras.create');
            Route::post('/facturas_compras/crear', 'store')->name('facturas_compras.store');
            Route::get('/facturas_compras/{id}/editar', 'edit')->name('facturas_compras.edit')->whereNumber('id');
            Route::put('/facturas_compras/{id}/editar', 'update')->name('facturas_compras.update')->whereNumber('id');
            Route::get('/facturas_compras/{id}/pdf', 'pdf')->name('facturas_compras.pdf')->whereNumber('id');
        });
    });

    // Turnos (Venta de servicios)
    Route::middleware('permission:venta de servicios|listado de venta de servicios|ver venta de servicios')->group(function () {
        Route::controller(TurnoController::class)->group(function () {
            Route::get('/turnos', 'index')->name('turnos.index');
            Route::get('/turnos/{id}', 'show')->name('turnos.show')->whereNumber('id');
            Route::get('/turnos/crear', 'create')->name('turnos.create');
            Route::post('/turnos/crear', 'store')->name('turnos.store');
            Route::get('/turnos/empleados-por-servicio/{servicio_id}', [TurnoController::class, 'getEmpleadosPorServicio'])->name('turnos.empleadosPorServicio');
            Route::get('/turnos/{id}/editar', 'edit')->name('turnos.edit')->whereNumber('id');
            Route::put('/turnos/{id}/editar', 'update')->name('turnos.update')->whereNumber('id');
        });
    });

    // Clientes
    Route::middleware('permission:listado de clientes|registrar cliente')->group(function () {
        Route::get('/clientes/buscar', [\App\Http\Controllers\ClienteController::class, 'buscar'])->name('clientes.buscar');
        Route::get('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'create'])->name('Clientes.create');
        Route::get('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'create'])->name('Clientes.formulariocliente');
        Route::post('/Clientes/crear', [\App\Http\Controllers\ClienteController::class, 'store'])->name('Clientes.store');
        Route::get('/Clientes', [\App\Http\Controllers\ClienteController::class, 'index'])->name('Clientes.indexCliente');
        Route::get('/Clientes/{id}', [\App\Http\Controllers\ClienteController::class, 'show'])->name('Clientes.detalleCliente')->whereNumber('id');
        Route::get('/Clientes/{id}/editar', [\App\Http\Controllers\ClienteController::class, 'edit'])->name('Clientes.edit');
        Route::put('/Clientes/{id}', [\App\Http\Controllers\ClienteController::class, 'update'])->name('Clientes.update');
    });

    // Instalaciones
    Route::middleware('permission:listado de instalación|registrar instalación|ver instalación')->group(function () {
        Route::get('/instalaciones/formulario', [\App\Http\Controllers\InstalacionController::class, 'create'])->name('instalaciones.formulario');
        Route::post('/instalaciones', [\App\Http\Controllers\InstalacionController::class, 'store'])->name('instalaciones.store');
        Route::get('/instalaciones', [\App\Http\Controllers\InstalacionController::class, 'index'])->name('instalaciones.index');
        Route::get('/instalaciones/eventos', [\App\Http\Controllers\InstalacionController::class, 'eventos'])->name('instalaciones.eventos');
    });

    // Asistencias
    Route::middleware('permission:listado de asistencias|registrar asistencias|ver asistencias')->group(function () {
        Route::get('/asistencias/index', [\App\Http\Controllers\AsistenciaController::class, 'index'])->name('asistencias.index');
        Route::get('/asistencias/crear', [\App\Http\Controllers\AsistenciaController::class, 'create'])->name('asistencias.crear');
        Route::post('/asistencias', [\App\Http\Controllers\AsistenciaController::class, 'store'])->name('asistencias.store');
        Route::get('asistencias/buscar', [\App\Http\Controllers\AsistenciaController::class, 'buscar'])->name('asistencias.buscar');
        Route::get('/asistencias/{id}', [\App\Http\Controllers\AsistenciaController::class, 'show'])->name('asistencias.show');
        Route::get('/asistencias/historial', [\App\Http\Controllers\AsistenciaController::class, 'historial'])->name('asistencias.historial');
    });

    // Incidencias
    Route::get('/incidencias', [\App\Http\Controllers\IncidenciaController::class, 'index'])->middleware('permission:listado de incidencias')->name('incidencias.index');
    Route::get('/incidencias/reporte', [\App\Http\Controllers\IncidenciaController::class, 'reporte'])->middleware('permission:listado de incidencias')->name('incidencias.reporte');
    Route::get('/incidencias/crear', [\App\Http\Controllers\IncidenciaController::class, 'create'])->middleware('permission:registrar incidencias')->name('incidencias.formulario');
    Route::post('/incidencias/crear', [\App\Http\Controllers\IncidenciaController::class, 'store'])->middleware('permission:registrar incidencias')->name('incidencias.store');
    Route::get('/incidencias/{id}', [\App\Http\Controllers\IncidenciaController::class, 'show'])->middleware('permission:ver incidencias')->name('incidencias.detalle')->whereNumber('id');
    Route::get('/incidencias/{id}/editar', [\App\Http\Controllers\IncidenciaController::class, 'edit'])->middleware('permission:editar incidencias')->name('incidencias.edit');
    Route::put('/incidencias/{id}', [\App\Http\Controllers\IncidenciaController::class, 'update'])->middleware('permission:editar incidencias')->name('incidencias.update');

    // Capacitaciones
    Route::get('/capacitaciones', [CapacitacionController::class, 'index'])->middleware('permission:listado de capacitación')->name('capacitaciones.index');
    Route::get('/capacitaciones/formulario', [CapacitacionController::class, 'create'])->middleware('permission:registrar capacitación')->name('capacitaciones.formulario');
    Route::post('/capacitaciones', [CapacitacionController::class, 'store'])->middleware('permission:registrar capacitación')->name('capacitaciones.store');
    Route::get('/capacitaciones/{id}/detalle', [CapacitacionController::class, 'show'])->middleware('permission:ver capacitación')->name('capacitaciones.detalle');
    Route::get('/capacitaciones/{id}/edit', [CapacitacionController::class, 'edit'])->middleware('permission:editar capacitación')->name('capacitaciones.edit');
    Route::put('/capacitaciones/{id}', [CapacitacionController::class, 'update'])->middleware('permission:editar capacitación')->name('capacitaciones.update');
    Route::delete('/capacitaciones/{id}', [CapacitacionController::class, 'destroy'])->middleware('permission:editar capacitación')->name('capacitaciones.destroy');

    // Rutas de 2FA (configuración)
    Route::get('/two-factor/setup', [\App\Http\Controllers\TwoFactorController::class, 'showSetup'])->name('two-factor.setup');
    Route::post('/two-factor/enable', [\App\Http\Controllers\TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::get('/two-factor/manage', [\App\Http\Controllers\TwoFactorController::class, 'showManage'])->name('two-factor.manage');
    Route::post('/two-factor/disable', [\App\Http\Controllers\TwoFactorController::class, 'disable'])->name('two-factor.disable');
    Route::get('/two-factor/recovery-codes', [\App\Http\Controllers\TwoFactorController::class, 'showRecoveryCodes'])->name('two-factor.recovery-codes');

    // Roles, permisos y usuarios (solo super_admin)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('usuarios', \App\Http\Controllers\UserController::class);
        Route::prefix('roles')->name('roles_permisos.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/asignar', [RoleController::class, 'asignarRol'])->name('asignar');
            Route::post('/guardar', [RoleController::class, 'guardarRol'])->name('guardar');
            Route::get('/ver/{id}', [RoleController::class, 'ver'])->name('ver');
            Route::get('/editar/{id}', [RoleController::class, 'editar'])->name('editar');
            Route::put('/actualizar/{id}', [RoleController::class, 'actualizar'])->name('actualizar');
        });
    });
});
