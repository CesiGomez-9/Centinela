<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo Centinela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>
<body>

<style>
    .pagination .page-item.active .page-link {
        background-color: #0A1F44; /* Cambia esto al color que quieras */
        border-color: #0A1F44;
        color: white;
    }

    .pagination .page-link {
        color: #0A1F44;
    }

    .pagination .page-link:hover {
        background-color: #0A1F44; /* Hover */

        .dropdown-item {
            font-size: 0.875rem;
            color: #212529; }
    }
    .dropdown-item:hover {
        background-color: #e9ecef;
    }
</style>
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 0.1rem; padding-bottom: 0.1rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="/"> <img src="<?php echo e(asset('centinela.jpg')); ?>"  style="height:80px; margin-right: 10px;">Grupo Centinela</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white d-flex align-items-center" href="<?php echo e(route('login')); ?>">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex align-items-center" href="<?php echo e(route('users.create')); ?>">Regístrate</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Producto</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('productos.index')); ?>">Inventario de productos</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('productos.create')); ?>">Registrar producto</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('facturas_compras.index')); ?>">Listado de facturas de compra</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('facturas_compras.create')); ?>">Registrar una factura de compra</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('facturas_ventas.index')); ?>">Listado de facturas de venta</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('facturas_ventas.create')); ?>">Registrar una factura de venta</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Servicios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('servicios.catalogo')); ?>">Listado de servicios</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('servicios.index')); ?>">Registrar servicio</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('turnos.create')); ?>">Venta de servicios</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('turnos.index')); ?>">Listado de venta de servicios</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('incidencias.formulario')); ?>">Registrar incidencia</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('incidencias.index')); ?>">Listado de incidencias</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Instalaciones</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('instalaciones.index')); ?>">Listado de instalaciones</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('instalaciones.formulario')); ?>">Registrar instalación</a></li>

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Empleados</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('empleados.index')); ?>">Listado de empleados</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('empleados.create')); ?>">Registrar empleado</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('memorandos.index')); ?>">Listado de memorandum</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('memorandos.create')); ?>">Registrar memorandum</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('asistencias.index')); ?>">Listado de asistencias</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('asistencias.crear')); ?>">Registrar asistencias</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('incapacidades.index')); ?>">Listado de incapacidad</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('incapacidades.create')); ?>">Registrar incapacidad</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('capacitaciones.index')); ?>">Listado de capacitaciones</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('capacitaciones.formulario')); ?>">Registrar capacitación</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Clientes</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('Clientes.indexCliente')); ?>">Listado de clientes</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('Clientes.formulariocliente')); ?>">Registrar cliente</a></li>
                        <li><hr class="dropdown-divider"></li> 
                        <li><a class="dropdown-item" href="<?php echo e(route('promociones.index')); ?>">Listado de promociones</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('promociones.create')); ?>">Registrar promociones</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Proveedores</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('Proveedores.indexProveedor')); ?>">Listado de proveedores</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('Proveedores.nuevo')); ?>">Registrar proveedor</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex align-items-center" href="<?php echo e(route('quienes_somos')); ?>">¿Quiénes Somos?</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-4">
    <?php echo $__env->yieldContent('content'); ?>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/plantilla.blade.php ENDPATH**/ ?>