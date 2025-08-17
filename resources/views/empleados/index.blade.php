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
            <img src="{{ asset('centinela.jpg') }}" style="height:80px; margin-right: 10px;">
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

        <div class="row mb-4 align-items-center">
            <div class="col-md-6 d-flex justify-content-start">
                <div class="w-100" style="max-width: 400px;">
                    <form method="GET" action="{{ route('empleados.index') }}">
                        <div class="input-group">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Buscar por nombre, departamento o identidad"
                                autocomplete="off"
                            />
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a href="{{ route('empleados.create') }}" class="btn btn-md btn-outline-primary">
                    <i class="bi bi-pencil-square me-2"></i>Registrar un nuevo empleado
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($empleados as $empleado)
                <tr>
                    <td>{{ $empleados->firstItem() + $loop->index }}</td>
                    <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                        {{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                    <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                        {{ $empleado->departamento }}</td>
                    <td>{{ $empleado->telefono }}</td>
                    <td class="text-center">
                        <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                            <i class="bi bi-pencil-square"></i>Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay empleados registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @if(request('search') && $empleados->total() > 0)
            <div class="mb-3 text-muted">
                Mostrando {{ $empleados->count() }} de {{ $empleados->total() }} empleados encontrados para
                "<strong>{{ request('search') }}</strong>".
            </div>
        @elseif(request('search') && $empleados->total() === 0)
            <div class="mb-3 text-danger">
                No se encontraron resultados para "<strong>{{ request('search') }}</strong>".
            </div>
        @endif

        <div class="d-flex justify-content-center mt-4">
            {{ $empleados->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@if ($errors->any())
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const form = searchInput.closest('form');

        if (form) {
            form.addEventListener('submit', e => {
                e.preventDefault();
            });
        }

        searchInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });

        let timeout = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const search = this.value.trim();
                const url = new URL(window.location.href);

                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }

                window.location.href = url.toString();
            }, 400);
        });
    });
</script>
</body>
</html>
