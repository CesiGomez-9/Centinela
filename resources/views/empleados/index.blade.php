<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleados Registrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #e6f0ff;">
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/logo.jpg') }}" style="height:80px; margin-right: 10px;">
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

<div class="container mt-5" style="max-width: 1100px;">
    <div class="card shadow p-4" style="background-color: #ffffff;">
        <h2 class="mb-4">Empleados Registrados</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row mb-3">
            <div class="col-auto">
                <a href="{{ route('empleados.create') }}" class="btn btn-primary btn-sm mb-3">Registrar Nuevo Empleado</a>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Identidad</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Emergencia</th>
                <th>Sangre</th>
                <th>Alergias</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($empleados as $empleado)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                    <td>{{ $empleado->identidad }}</td>
                    <td>{{ $empleado->email }}</td>
                    <td>{{ $empleado->telefono }}</td>
                    <td>{{ $empleado->contactodeemergencia }}<br>({{ $empleado->telefonodeemergencia }})</td>
                    <td>{{ $empleado->tipodesangre }}</td>
                    <td>{{ $empleado->alergias }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay empleados registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
