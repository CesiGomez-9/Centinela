<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleados Registrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        <h3 class="text-center mb-4" style="color: #09457f;">
            <i class="bi bi-people-fill me-2"></i>
            Lista de empleados
        </h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-auto">
                <a href="{{ route('empleados.create') }}" class="btn btn-sm btn-outline-primary mb-2"><- Volver al formulario</a>
            </div>
            <div class="col d-flex justify-content-end">
                <form id="searchForm" action="{{ route('empleados.index') }}" method="GET" class="w-100" style="max-width: 300px;" novalidate>
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            id="searchInput"
                            class="form-control form-control-sm"
                            placeholder="Buscar por nombre"
                            value="{{ request('search') }}"
                            maxlength="25"
                        >
                        <button class="btn btn-sm btn-primary" type="submit">Buscar</button>
                    </div>
                    <div class="invalid-feedback d-block text-danger small mt-1 d-none" id="error-search">
                        Ingrese un nombre antes de buscar
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($empleados as $empleado)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                    <td>{{ $empleado->direccion }}</td>
                    <td>{{ $empleado->telefono }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay empleados registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $empleados->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('searchForm').addEventListener('submit', function (e) {
        const input = document.getElementById('searchInput');
        const error = document.getElementById('error-search');
        const value = input.value.trim();
        const regex = /^[A-Za-z]{1,25}$/;

        if (!regex.test(value)) {
            e.preventDefault();
            error.classList.remove('d-none');
            input.classList.add('is-invalid');
        } else {
            error.classList.add('d-none');
            input.classList.remove('is-invalid');
        }
    });
    document.getElementById('searchInput').addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/^[a-zA-Z]$/.test(char)) {
            event.preventDefault();
        }
    });
</script>
</body>
</html>
