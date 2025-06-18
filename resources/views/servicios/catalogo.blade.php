
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Servicios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f4f8;
            font-family: 'Segoe UI', sans-serif;
        }
        .table thead th {
            text-align: center;
            vertical-align: middle;
        }
        .table tbody td {
            vertical-align: middle;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            margin-right: 12px;
        }
        .search-alert {
            font-size: 0.9rem;
            color: red;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body class="bg-light p-4">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #0A1F44;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/GrupoCentinela.jpg') }}" style="height:70px;">
            Grupo Centinela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon text-white"></span>
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

<!-- CONTENIDO -->
<div class="container bg-white p-5 rounded shadow mt-4">

    <!-- Título centrado -->
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-list-check me-2"></i>Lista de servicios
        </h2>
    </div>

 <!-- Botón de volver a la derecha y buscador a la izquierda -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-row-reverse">
        <!-- Botón Volver a la derecha -->
        <a href="{{ route('servicios.index') }}" class="btn btn-outline-primary btn-md">
            <i class="bi bi-arrow-left-circle me-2"></i>Crear un registro nuevo
        </a>

        <!-- Formulario de búsqueda a la izquierda -->
        <form id="formBuscar" action="{{ route('servicios.catalogo') }}" method="GET" class="d-flex flex-column" style="max-width: 350px;">
            <div class="input-group">
                <input type="text" id="campoBuscar" name="search" class="form-control" placeholder="Buscar por nombre..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <div id="errorBuscar" class="search-alert d-none">
                Por favor, ingresa solo letras y no dejes el campo vacío.
            </div>
        </form>
    </div>


    <!-- Alerta de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Tipo</th>
            </tr>
            </thead>
            <tbody>
            @forelse($servicios as $servicio)
                <tr>
                    <td class="text-start">{{ $servicio->nombre }}</td>
                    <td class="text-start">{{ Str::limit($servicio->descripcion, 80) }}</td>
                    <td class="text-start">{{ $servicio->tipo }}</td>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No hay servicios registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $servicios->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Validación con JavaScript -->
<script>
    const campoBuscar = document.getElementById('campoBuscar');
    const errorDiv = document.getElementById('errorBuscar');
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    campoBuscar.addEventListener('input', function () {
        this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
        errorDiv.classList.add('d-none');
    });

    campoBuscar.form.addEventListener('submit', function (e) {
        const valor = campoBuscar.value.trim();

        if (valor !== "" && !soloLetras.test(valor)) {
            e.preventDefault();
            errorDiv.classList.remove('d-none');
        } else {
            errorDiv.classList.add('d-none');
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
