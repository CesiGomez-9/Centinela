@extends("plantilla")
@section('titulo', 'Turnos')
@section('content')
    <style>
        body {
            background-color: #e6f0ff;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .table-black-header th {
            background-color: #000000;
            color: #ffffff;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .table-striped tbody tr:hover {
            background-color: #e2f2ff;
        }

        .btn-outline-info, .btn-outline-warning {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-outline-primary, .btn-primary {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .input-group-text {
            border-radius: 0.5rem 0 0 0.5rem;
        }

        /* Ajuste para los campos de fecha y botones pequeños */
        .input-group.input-group-sm .form-control {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Alineación del grupo de botones */
        .form-group-with-button {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }
        .form-group-with-button .input-group {
            flex-grow: 1;
        }

        .date-input-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-grow: 1;
        }

        .date-input-container > div {
            flex-grow: 1;
        }
        .date-input-container > .input-group {
            width: calc(50% - 0.5rem); /* Ajuste para dejar espacio al botón */
        }
    </style>

    <div class="container my-5" style="max-width: 1100px;">
        {{-- Mensajes de sesión --}}
        @if(session('exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('exito') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if(session('fracaso'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('fracaso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-calendar-check-fill me-2"></i> Listado de asignación de servicios
            </h3>

            {{-- Formulario de búsqueda y filtrado --}}
            <form method="GET" action="{{ route('turnos.index') }}" id="filterForm" autocomplete="off">
                <div class="row mb-4 g-2 d-flex flex-wrap align-items-start">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                class="form-control"
                                maxlength="30"
                                placeholder="Buscar por cliente o servicio..."
                                value="{{ request('search') }}">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-2 ms-4 d-flex flex-column gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Desde</span>
                            <input type="date" name="fecha_inicio" id="fechaInicio" class="form-control" value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Hasta</span>
                            <input type="date" name="fecha_fin" id="fechaFin" class="form-control" value="{{ request('fecha_fin') }}">
                        </div>
                    </div>
                    <div class="col-md-2 ms-3 d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('turnos.index') }}" class="btn btn-sm btn-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i> Limpiar
                        </a>
                    </div>
                    <div class="col-md-3 ms-auto">
                        <a href="{{ route('turnos.create') }}"  class="btn btn-md btn-outline-primary w-80">
                            <i class="bi bi-plus-circle me-1"></i> Asignar un servicio
                        </a>
                    </div>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            {{-- Tabla de turnos --}}
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-black-header">
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Fecha inicio</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($turnos as $turno)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $turno->cliente->nombre }} {{ $turno->cliente->apellido }}</td>
                            <td>{{ $turno->servicio->nombre }}</td>
                            <td>{{ \Carbon\Carbon::parse($turno->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('turnos.show', $turno->id) }}" class="btn btn-sm btn-outline-info" title="Ver detalle">
                                    <i class="bi bi-eye"> Ver</i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No hay turnos registrados.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Sección de resultados de búsqueda --}}
            @if(request('search') || request('fecha_inicio') || request('fecha_fin'))
                <div class="mb-3 text-muted">
                    Mostrando {{ $turnos->count() }} de {{ $turnos->total() }} resultados encontrados.
                </div>
                @if($turnos->total() === 0)
                    <div class="mb-3 text-danger">
                        No se encontraron resultados para los filtros aplicados.
                    </div>
                @endif
            @endif

            {{-- Paginación --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $turnos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Script para la funcionalidad de búsqueda y filtros --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const filterForm = document.querySelector('form[action="{{ route('turnos.index') }}"]');
            let timeout = null;

            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 500);
            });
        });
    </script>
@endsection
