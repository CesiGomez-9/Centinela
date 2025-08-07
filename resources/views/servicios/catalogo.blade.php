<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Servicios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        body {
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
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
        .pagination .page-item.active .page-link {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
        }
        /* Ajuste para la columna de costos */
        .cost-details {
            font-size: 0.9em; /* Ligeramente más pequeño para caber mejor */
            line-height: 1.3; /* Espaciado entre líneas */
        }
        .cost-details strong {
            display: inline-block; /* Asegura que la etiqueta y el valor estén en la misma línea */
            min-width: 45px; /* Alinea las etiquetas */
            text-align: right;
            margin-right: 5px;
        }
    </style>

</head>



</style>
<body class="bg-light p-4">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #0A1F44;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('centinela.jpg') }}" style="height:70px;">
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
<div class="container bg-white p-5 rounded shadow mt-5">

    <!-- Título -->
    <div class="text-center mb-3">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-list-check me-2"></i>Lista de servicios
        </h2>
    </div>

    <!-- Buscador y botón -->
    <div class="d-flex justify-content-between align-items-start mb-5 flex-wrap w-100">
        <!-- Formulario búsqueda -->
        <form method="GET" action="{{ route('servicios.catalogo') }}" style="width: 400px;" class="align-self-start">
            <div class="input-group">
                <input type="text" id="searchInput" name="search" class="form-control form-control-md"
                       placeholder="Buscar por nombre..." value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- Botón crear -->
        <a href="{{ route('servicios.index') }}" class="btn btn-outline-primary d-block align-self-start" style="width: 300px;">
            <i class="bi bi-pencil-square me-2"></i> Crear un registro nuevo
        </a>
    </div>

    <!-- Alerta éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <!-- Tabla -->
    <div class="table-responsive mx-auto" style="max-width: 1100px;">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
            <tr>
                <th style="width: 50px;">#</th>
                <th style="width: 280px;">Nombre</th>
                <th style="width: 200px;">Costos</th> {{-- Cambiado de "Costo estimado" a "Costos" --}}
                <th style="width: 130px;">Categoría</th>
                <th style="width: 160px;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($servicios as $index => $servicio)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-start text-truncate" style="max-width: 280px;">{{ $servicio->nombre }}</td>
                    <td class="text-start cost-details"> {{-- Alineación a la izquierda para los detalles de costo --}}
                        <div><strong>Diurno:</strong> L. {{ number_format($servicio->costo_diurno, 2) }}</div>
                        <div><strong>Nocturno:</strong> L. {{ number_format($servicio->costo_nocturno, 2) }}</div>
                        <div><strong>24 horas:</strong> L. {{ number_format($servicio->costo_24_horas, 2) }}</div>
                    </td>
                    <td class="text-start">{{ ucfirst($servicio->categoria) }}</td>
                    <td class="text-center">
                        <a href="{{ route('servicios.show', $servicio->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay servicios registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mensajes búsqueda -->
    @if(request('search') && $servicios->total() > 0)
        <div class="mb-3 text-muted">
            Mostrando {{ $servicios->count() }} de {{ $servicios->total() }} servicios encontrados para
            "<strong>{{ request('search') }}</strong>".
        </div>
    @elseif(request('search') && $servicios->total() === 0)
        <div class="mb-3 text-danger">
            No se encontraron resultados para "<strong>{{ request('search') }}</strong>".
        </div>
    @endif

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $servicios->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- JS búsqueda rápida -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');

        if (searchInput.value !== '') {
            searchInput.focus();
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }

        let timeout = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const search = this.value;
                const url = new URL(window.location.href);
                url.searchParams.set('search', search);
                window.location.href = url.toString();
            }, 700);
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
