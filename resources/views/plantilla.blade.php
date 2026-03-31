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
                    {{ Auth::user()->empleado->nombre ?? Auth::user()->usuario }}
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <span class="dropdown-item-text text-muted small">
                            <i class="bi bi-shield-fill me-1"></i>
                            {{ Auth::user()->rol ?? 'Sin rol' }}
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
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

            @php $isSuperAdmin = Auth::user()->hasRole('super_admin'); @endphp

            {{-- MÓDULO: PRODUCTOS --}}
            @php
                $verProductos     = $isSuperAdmin || Auth::user()->can('listado de producto') || Auth::user()->can('inventario de producto');
                $verFactCompra    = $isSuperAdmin || Auth::user()->can('listado de factura de compra') || Auth::user()->can('registrar factura de compra');
                $verFactVenta     = $isSuperAdmin || Auth::user()->can('listado de factura de venta') || Auth::user()->can('registrar factura de venta');
                $mostrarProductos = $verProductos || $verFactCompra || $verFactVenta;
            @endphp
            @if($mostrarProductos)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-box-seam me-2"></i>Producto
                </a>
                <ul class="dropdown-menu">
                    @if($isSuperAdmin || Auth::user()->can('inventario de producto'))
                        <li><a class="dropdown-item" href="{{ route('productos.index') }}">Inventario de productos</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar producto'))
                        <li><a class="dropdown-item" href="{{ route('productos.create') }}">Registrar producto</a></li>
                    @endif
                    @if($verFactCompra)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de factura de compra'))
                        <li><a class="dropdown-item" href="{{ route('facturas_compras.index') }}">Listado de facturas de compra</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar factura de compra'))
                        <li><a class="dropdown-item" href="{{ route('facturas_compras.create') }}">Registrar factura de compra</a></li>
                    @endif
                    @if($verFactVenta)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de factura de venta'))
                        <li><a class="dropdown-item" href="{{ route('facturas_ventas.index') }}">Listado de facturas de venta</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar factura de venta'))
                        <li><a class="dropdown-item" href="{{ route('facturas_ventas.create') }}">Registrar factura de venta</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- MÓDULO: SERVICIOS --}}
            @php
                $verServicios    = $isSuperAdmin || Auth::user()->can('listado de servicio') || Auth::user()->can('registrar servicio');
                $verVentas       = $isSuperAdmin || Auth::user()->can('listado de venta de servicios') || Auth::user()->can('venta de servicios');
                $verIncidencias  = $isSuperAdmin || Auth::user()->can('listado de incidencias') || Auth::user()->can('registrar incidencias');
                $mostrarServicios = $verServicios || $verVentas || $verIncidencias;
            @endphp
            @if($mostrarServicios)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-gear-fill me-2"></i>Servicios
                </a>
                <ul class="dropdown-menu">
                    @if($isSuperAdmin || Auth::user()->can('listado de servicio'))
                        <li><a class="dropdown-item" href="{{ route('servicios.catalogo') }}">Listado de servicios</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar servicio'))
                        <li><a class="dropdown-item" href="{{ route('servicios.index') }}">Registrar servicio</a></li>
                    @endif
                    @if($verVentas)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('venta de servicios'))
                        <li><a class="dropdown-item" href="{{ route('turnos.create') }}">Venta de servicios</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de venta de servicios'))
                        <li><a class="dropdown-item" href="{{ route('turnos.index') }}">Listado de venta de servicios</a></li>
                    @endif
                    @if($verIncidencias)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar incidencias'))
                        <li><a class="dropdown-item" href="{{ route('incidencias.formulario') }}">Registrar incidencia</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de incidencias'))
                        <li><a class="dropdown-item" href="{{ route('incidencias.index') }}">Listado de incidencias</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- MÓDULO: INSTALACIONES --}}
            @if($isSuperAdmin || Auth::user()->can('listado de instalación') || Auth::user()->can('registrar instalación'))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-building me-2"></i>Instalaciones
                </a>
                <ul class="dropdown-menu">
                    @if($isSuperAdmin || Auth::user()->can('listado de instalación'))
                        <li><a class="dropdown-item" href="{{ route('instalaciones.index') }}">Listado de instalaciones</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar instalación'))
                        <li><a class="dropdown-item" href="{{ route('instalaciones.formulario') }}">Registrar instalación</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- MÓDULO: EMPLEADOS --}}
            @php
                $verEmpleados     = $isSuperAdmin || Auth::user()->can('listado de empleados') || Auth::user()->can('registrar empleados');
                $verMemorandos    = $isSuperAdmin || Auth::user()->can('listado de memorándum') || Auth::user()->can('registrar memorándum');
                $verAsistencias   = $isSuperAdmin || Auth::user()->can('listado de asistencias') || Auth::user()->can('registrar asistencias');
                $verIncapacidades = $isSuperAdmin || Auth::user()->can('listado de incapacidad') || Auth::user()->can('registrar incapacidad');
                $verCapacitaciones= $isSuperAdmin || Auth::user()->can('listado de capacitación') || Auth::user()->can('registrar capacitación');
                $mostrarEmpleados = $verEmpleados || $verMemorandos || $verAsistencias || $verIncapacidades || $verCapacitaciones;
            @endphp
            @if($mostrarEmpleados)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-people-fill me-2"></i>Empleados
                </a>
                <ul class="dropdown-menu">
                    @if($isSuperAdmin || Auth::user()->can('listado de empleados'))
                        <li><a class="dropdown-item" href="{{ route('empleados.index') }}">Listado de empleados</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar empleados'))
                        <li><a class="dropdown-item" href="{{ route('empleados.create') }}">Registrar empleado</a></li>
                    @endif
                    @if($verMemorandos)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de memorándum'))
                        <li><a class="dropdown-item" href="{{ route('memorandos.index') }}">Listado de memorandum</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar memorándum'))
                        <li><a class="dropdown-item" href="{{ route('memorandos.create') }}">Registrar memorandum</a></li>
                    @endif
                    @if($verAsistencias)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de asistencias'))
                        <li><a class="dropdown-item" href="{{ route('asistencias.index') }}">Listado de asistencias</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar asistencias'))
                        <li><a class="dropdown-item" href="{{ route('asistencias.crear') }}">Registrar asistencias</a></li>
                    @endif
                    @if($verIncapacidades)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de incapacidad'))
                        <li><a class="dropdown-item" href="{{ route('incapacidades.index') }}">Listado de incapacidad</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar incapacidad'))
                        <li><a class="dropdown-item" href="{{ route('incapacidades.create') }}">Registrar incapacidad</a></li>
                    @endif
                    @if($verCapacitaciones)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de capacitación'))
                        <li><a class="dropdown-item" href="{{ route('capacitaciones.index') }}">Listado de capacitaciones</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar capacitación'))
                        <li><a class="dropdown-item" href="{{ route('capacitaciones.formulario') }}">Registrar capacitación</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- MÓDULO: CLIENTES --}}
            @php
                $verClientes    = $isSuperAdmin || Auth::user()->can('listado de clientes') || Auth::user()->can('registrar cliente');
                $verPromociones = $isSuperAdmin || Auth::user()->can('listado de promociones') || Auth::user()->can('registrar promociones');
                $mostrarClientes = $verClientes || $verPromociones;
            @endphp
            @if($mostrarClientes)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-lines-fill me-2"></i>Clientes
                </a>
                <ul class="dropdown-menu">
                    @if($isSuperAdmin || Auth::user()->can('listado de clientes'))
                        <li><a class="dropdown-item" href="{{ route('Clientes.indexCliente') }}">Listado de clientes</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar cliente'))
                        <li><a class="dropdown-item" href="{{ route('Clientes.formulariocliente') }}">Registrar cliente</a></li>
                    @endif
                    @if($verPromociones)
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('listado de promociones'))
                        <li><a class="dropdown-item" href="{{ route('promociones.index') }}">Listado de promociones</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar promociones'))
                        <li><a class="dropdown-item" href="{{ route('promociones.create') }}">Registrar promociones</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- MÓDULO: PROVEEDORES --}}
            @if($isSuperAdmin || Auth::user()->can('listado de proveedores') || Auth::user()->can('registrar proveedor'))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-truck me-2"></i>Proveedores
                </a>
                <ul class="dropdown-menu">
                    @if($isSuperAdmin || Auth::user()->can('listado de proveedores'))
                        <li><a class="dropdown-item" href="{{ route('Proveedores.indexProveedor') }}">Listado de proveedores</a></li>
                    @endif
                    @if($isSuperAdmin || Auth::user()->can('registrar proveedor'))
                        <li><a class="dropdown-item" href="{{ route('Proveedores.nuevo') }}">Registrar proveedor</a></li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- MÓDULO: USUARIOS --}}
            @if($isSuperAdmin)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-badge me-2"></i>Usuarios
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Listado de usuarios</a></li>
                    <li><a class="dropdown-item" href="{{ route('users.create') }}">Registrar usuario</a></li>
                </ul>
            </li>
            @endif

            {{-- MÓDULO: ROLES Y PERMISOS (solo super_admin) --}}
            @if($isSuperAdmin)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-shield-lock-fill me-2"></i>Roles y permisos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('roles_permisos.index') }}">Listado de roles</a></li>
                    <li><a class="dropdown-item" href="{{ route('roles_permisos.asignar') }}">Asignar roles</a></li>
                </ul>
            </li>
            @endif

        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
                </a>
            </li>
        @endauth
    </ul>
</nav>

<!-- Contenido principal -->
<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Impide que el navegador guarde esta página en bfcache.
    // Sin bfcache, al presionar atrás el navegador hace una nueva petición al
    // servidor, que detecta que no hay sesión y redirige al login.
    window.addEventListener('beforeunload', function () {});
</script>
</body>
</html>
