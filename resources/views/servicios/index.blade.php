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

    <h2 class="mb-4">Registro de Servicio</h2>

    <div class="mb-4 text-end">
        <a href="{{ route('servicios.catalogo') }}" class="btn btn-primary">Ver catálogo de servicios</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('servicios.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <label>Nombre del servicio</label>
                <input type="text" name="nombre_servicio" class="form-control" required>
            </div>
            <div class="col">
                <label>Ciudad / Municipio</label>
                <input type="text" name="ciudad" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Descripción detallada</label>
            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Fecha de inicio del servicio</label>
                <input type="date" name="fecha_inicio" class="form-control" required>
            </div>
            <div class="col">
                <label>Duración estimada</label>
                <input type="text" name="duracion" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Horario del servicio</label>
                <input type="text" name="horario" class="form-control" required>
            </div>
            <div class="col">
                <label>Cantidad de personal requerido</label>
                <input type="number" name="cantidad_personal" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Tipo de personal</label>
                <input type="text" name="tipo_personal" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Incluye equipamiento</label>
            <select name="incluye_equipamiento" class="form-control">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Fecha de solicitud</label>
            <input type="date" name="fecha_solicitud" class="form-control" required>
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
        if (confirm('¿Estás seguro de que deseas borrar los datos ingresados?')) {
            document.querySelector('form').reset();
        }
    }
</script>

</body>
</html>
