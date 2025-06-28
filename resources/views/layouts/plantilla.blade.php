<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo Centinela</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    }
</style>

<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 0.1rem; padding-bottom: 0.1rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="/"> <img src="{{ asset('centinela.jpg') }}"  style="height:80px; margin-right: 10px;">Grupo Centinela</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-link text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Producto</a>
                    <ul class="dropdown-menu">
                        <li class="nav-link text-white"><a class="dropdown-item" href="{{route('productos.index')}}">Listado de productos</a></li>
                        <li class="nav-link text-white"><a class="dropdown-item" href="{{route('productos.create')}}">Registrar un nuevo producto</a></li>
                        <li class="nav-link text-white"><a class="dropdown-item" href="{{route('facturas.index')}}">Listado de facturas</a></li>
                        <li class="nav-link text-white"><a class="dropdown-item" href="{{route('facturas.create')}}">Registrar una nueva factura</a></li>

                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrate</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container my-4">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
