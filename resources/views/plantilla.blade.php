<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo Centinela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #0A1F44;
            padding-top: 20px;
            box-shadow: 4px 0 12px rgba(0,0,0,0.2);
            overflow-y: auto;
        }

        .sidebar .navbar-brand {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff !important;
            padding-left: 1rem;
        }

        .sidebar .navbar-brand img {
            height: 60px;
            margin-right: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255,215,0,0.2);
            color: #FFD700 !important;
        }

        .sidebar .dropdown-menu {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            margin-left: 1rem;
        }

        .sidebar .dropdown-item {
            color: #0A1F44;
            font-weight: 500;
            transition: all 0.3s;
        }

        .sidebar .dropdown-item:hover {
            background-color: #e9ecef;
            color: #0A1F44;
        }

        .sidebar .dropdown-toggle::after {
            float: right;
            margin-top: 5px;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        /* Scroll para sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
    </style>
</head>
<body>

<!-- Sidebar vertical -->
<nav class="sidebar d-flex flex-column">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('centinela.jpg') }}" alt="Logo">
        Grupo Centinela
    </a>

    <ul class="nav flex-column">
        @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-2"></i>
                    {{ Auth::user()->empleado->nombre ?? Auth::user()->name }}
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item fw-bold">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
        @endauth

        <li class="nav-item"><a class="nav-link" href="{{ route('users.create') }}">Regístrate</a></li>

        <!-- Links principales -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Producto</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('productos.index')}}">Inventario de productos</a></li>
                <li><a class="dropdown-item" href="{{route('productos.create')}}">Registrar producto</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('facturas_compras.index')}}">Listado de facturas de compra</a></li>
                <li><a class="dropdown-item" href="{{route('facturas_compras.create')}}">Registrar una factura de compra</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('facturas_ventas.index')}}">Listado de facturas de venta</a></li>
                <li><a class="dropdown-item" href="{{route('facturas_ventas.create')}}">Registrar una factura de venta</a></li>
            </ul>
        </li>

        <!-- Repetir para todos los demás items: Servicios, Instalaciones, Empleados, Clientes, Proveedores, Roles y permisos, Quiénes somos -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Servicios</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('servicios.catalogo')}}">Listado de servicios</a></li>
                <li><a class="dropdown-item" href="{{route('servicios.index')}}">Registrar servicio</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('turnos.create')}}">Venta de servicios</a></li>
                <li><a class="dropdown-item" href="{{route('turnos.index')}}">Listado de venta de servicios</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('incidencias.formulario')}}">Registrar incidencia</a></li>
                <li><a class="dropdown-item" href="{{route('incidencias.index')}}">Listado de incidencias</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Instalaciones</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('instalaciones.index')}}">Listado de instalaciones</a></li>
                <li><a class="dropdown-item" href="{{route('instalaciones.formulario')}}">Registrar instalación</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Empleados</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('empleados.index')}}">Listado de empleados</a></li>
                <li><a class="dropdown-item" href="{{route('empleados.create')}}">Registrar empleado</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('memorandos.index')}}">Listado de memorandum</a></li>
                <li><a class="dropdown-item" href="{{route('memorandos.create')}}">Registrar memorandum</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('asistencias.index')}}">Listado de asistencias</a></li>
                <li><a class="dropdown-item" href="{{route('asistencias.crear')}}">Registrar asistencias</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('incapacidades.index')}}">Listado de incapacidad</a></li>
                <li><a class="dropdown-item" href="{{route('incapacidades.create')}}">Registrar incapacidad</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('capacitaciones.index')}}">Listado de capacitaciones</a></li>
                <li><a class="dropdown-item" href="{{route('capacitaciones.formulario')}}">Registrar capacitación</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Clientes</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('Clientes.indexCliente')}}">Listado de clientes</a></li>
                <li><a class="dropdown-item" href="{{route('Clientes.formulariocliente')}}">Registrar cliente</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('promociones.index')}}">Listado de promociones</a></li>
                <li><a class="dropdown-item" href="{{route('promociones.create')}}">Registrar promociones</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Proveedores</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('Proveedores.indexProveedor')}}">Listado de proveedores</a></li>
                <li><a class="dropdown-item" href="{{route('Proveedores.nuevo')}}">Registrar proveedor</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Roles y permisos</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('roles_permisos.index') }}">Listado de roles</a></li>
                <li><a class="dropdown-item" href="{{ route('roles_permisos.asignar') }}">Asignar roles</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('quienes_somos') }}">¿Quiénes Somos?</a>
        </li>
    </ul>
</nav>

<!-- Contenido principal -->
<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
