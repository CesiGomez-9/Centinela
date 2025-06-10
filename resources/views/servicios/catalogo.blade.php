<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Servicios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/GrupoCentinela.jpg') }}" style="height:80px; margin-right: 10px;">
            Grupo Centinela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrate</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container bg-white p-5 rounded shadow">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Catálogo de Servicios</h2>
        <a href="{{ route('servicios.index') }}" class="btn btn-outline-primary">← Volver al formulario</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Código</th>
            <th>Ingreso</th>
            <th>Proveedor</th>
            <th>Compra</th>
            <th>Venta</th>
            <th>Stock</th>

        </tr>
        </thead>
        <tbody>
        @forelse($servicios as $servicio)
            <tr>
                <td>{{ $servicio->id }}</td>
                <td>{{ $servicio->nombre }}</td>
                <td>{{ $servicio->categoria }}</td>
                <td>{{ $servicio->marca }}</td>
                <td>{{ $servicio->modelo }}</td>
                <td>{{ $servicio->codigo_interno }}</td>
                <td>{{ $servicio->fecha_ingreso }}</td>
                <td>{{ $servicio->proveedor }}</td>
                <td>L {{ number_format($servicio->precio_compra, 2) }}</td>
                <td>L {{ number_format($servicio->precio_venta, 2) }}</td>
                <td>{{ $servicio->unidades_stock }}</td>
                <td class="d-flex gap-2">
                     </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center">No hay servicios registrados.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
