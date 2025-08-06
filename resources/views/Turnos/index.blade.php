@extends("plantilla")
@section('titulo', 'Turnos')
@section('content')
    <style>
        body {
            background-color: #e6f0ff;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
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

        /* Ajuste para los campos de fecha */
        .input-group.input-group-sm .form-control {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>

    <div class="container mt-5 mb-5" style="max-width: 1100px;">
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
                <i class="bi bi-calendar-check-fill me-2"></i>
                Listado de asignación de turnos
            </h3>

            {{-- Formulario de búsqueda y filtrado --}}
            <form action="{{ route('turnos.index') }}" method="GET" id="filterForm">
                <div class="row mb-4 align-items-start">
                    {{-- Campo de búsqueda --}}
                    <div class="col-lg-5 col-md-12 mb-3">
                        <div class="input-group">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                maxlength="30"
                                placeholder="Buscar por cliente o servicio"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    {{-- Contenedor de filtros de fecha y botón de filtrar --}}
                    <div class="col-lg-4 col-md-12 mb-3 d-flex align-items-center">
                        <div class="d-flex flex-column me-2">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Desde</span>
                                <input type="date" name="fecha_inicio" id="fechaInicio" class="form-control"
                                       value="{{ request('fecha_inicio') }}">
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Hasta</span>
                                <input type="date" name="fecha_fin" id="fechaFin" class="form-control"
                                       value="{{ request('fecha_fin') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary mt-2">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                    </div>

                    {{-- Botón de asignar servicio --}}
                    <div class="col-lg-3 col-md-12 mb-3">
                        <a href="{{ route('turnos.create') }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-plus-circle me-2"></i>Asignar un servicio
                        </a>
                    </div>
                </div>

                {{-- Botón para limpiar filtros --}}
                <div class="row mb-4">
                    <div class="col-12 d-flex justify-content-end">
                        @if(request()->filled('search') || request()->filled('fecha_inicio') || request()->filled('fecha_fin'))
                            <a href="{{ route('turnos.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Limpiar Filtros
                            </a>
                        @endif
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
            <div class="table-responsive">
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
                            <td>{{ $turno->servicio->nombre }}}</td>
                            <td>{{ \Carbon\Carbon::parse($turno->fecha_inicio)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('turnos.show', $turno->id) }}" class="btn btn-sm btn-outline-info" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
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
            const filterForm = document.getElementById('filterForm');
            let timeout = null;

            // Restablecer el foco en el campo de búsqueda si ya tiene un valor
            if (searchInput.value !== '') {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }

            // Evento para el input de búsqueda con un pequeño retraso para evitar recargas excesivas
            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 500);
            });
        });
    </script>
@endsection
