<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Servicios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4 bg-light">
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
        <h2>Registro de Servicio</h2>
        <a href="{{ route('servicios.catalogo') }}" class="btn btn-outline-primary">Ver catálogo de servicios</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('servicios.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col">
                <label>Categoría</label>
                <input type="text" name="categoria" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Marca</label>
                <input type="text" name="marca" class="form-control" required>
            </div>
            <div class="col">
                <label>Modelo</label>
                <input type="text" name="modelo" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Código Interno</label>
                <input type="text" name="codigo_interno" class="form-control" required>
            </div>
            <div class="col">
                <label>Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Proveedor</label>
                <input type="text" name="proveedor" class="form-control">
            </div>
            <div class="col">
                <label>Precio de Compra</label>
                <input type="number" step="0.01" name="precio_compra" class="form-control" required>
            </div>
            <div class="col">
                <label>Precio de Venta</label>
                <input type="number" step="0.01" name="precio_venta" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Unidades en Stock</label>
            <input type="number" name="unidades_stock" class="form-control" required>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <button type="submit" class="btn btn-outline-success">Guardar</button>
            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
            <button type="button" class="btn btn-outline-danger" onclick="eliminarServicio()">Borrar</button>
        </div>

    </form>
</div>

<script>
    function eliminarServicio() {
        if (confirm('¿Estás seguro de que deseas borrar el servicio?')) {
            // Puedes implementar lógica con AJAX aquí o redirigir a una ruta de eliminación.
            alert('Aquí va la lógica de borrado específica.');
        }
    }
</script>
</body>
</html>
