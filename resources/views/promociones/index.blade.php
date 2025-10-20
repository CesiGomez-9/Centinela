@extends('plantilla')
@section('content')
    <style>
        .tabla-promociones td {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }

        /* Color para promociones vencidas */
        .promocion-expirada {
            background-color: #ffe6e6 !important;
        }
    </style>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-badge-ad me-2"></i>Lista de promociones
            </h3>

            <form method="GET" action="{{ route('promociones.index') }}">
                <div class="row mb-4 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                   placeholder="Buscar por nombre o descripción"
                                   value="{{ request('search') }}">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex flex-column gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Desde</span>
                            <input type="date" name="fecha_inicio" class="form-control"
                                   style="min-width: 160px;"
                                   value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Hasta</span>
                            <input type="date" name="fecha_fin" class="form-control"
                                   style="min-width: 160px;"
                                   value="{{ request('fecha_fin') }}">
                        </div>
                    </div>

                    <div class="col-md-2 d-flex flex-column gap-2 align-items-start">
                        <button type="submit" class="btn btn-sm btn-primary px-2 py-1" style="font-size: 12px; width: 90px;">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('promociones.index') }}" class="btn btn-sm btn-secondary px-2 py-1" style="font-size: 12px; width: 90px;">
                            <i class="bi bi-x-circle me-1"></i> Limpiar
                        </a>
                    </div>


                    <div class="col-md-3 ms-auto">
                        <a href="{{ route('promociones.create') }}" class="btn btn-md btn-outline-primary w-100">
                            <i class="bi bi-pencil-square me-0"></i> Registrar nueva promoción
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

            <div class="table-responsive">
                <table class="table table-bordered table-striped tabla-promociones align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Activo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($promociones as $promocion)
                        @php
                            $hoy = \Carbon\Carbon::now();
                            $inicio = \Carbon\Carbon::parse($promocion->fecha_inicio);
                            $fin = \Carbon\Carbon::parse($promocion->fecha_fin)->endOfDay(); // Incluye todo el día de fin
                            $esActiva = $hoy->between($inicio, $fin);
                        @endphp

                        <tr class="{{ !$esActiva ? 'promocion-expirada' : '' }}">
                            <td>{{ $loop->iteration + ($promociones->currentPage() - 1) * $promociones->perPage() }}</td>
                            <td>{{ $promocion->nombre }}</td>
                            <td>{{ Str::limit($promocion->descripcion, 50) }}</td>
                            <td>{{ $inicio->format('d/m/Y') }}</td>
                            <td>{{ $fin->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @if($esActiva)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('promociones.show', $promocion->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('promociones.edit', $promocion->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay promociones registradas.</td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>

            @if(request('search') && $promociones->total() > 0)
                <div class="mb-3 text-muted">
                    Mostrando {{ $promociones->count() }} de {{ $promociones->total() }} promociones encontradas para
                    "<strong>{{ request('search') }}</strong>".
                </div>
            @elseif(request('search') && $promociones->total() === 0)
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong>{{ request('search') }}</strong>".
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $promociones->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;

            searchInput.focus();
            const length = searchInput.value.length;
            searchInput.setSelectionRange(length, length);

            let timer;
            searchInput.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    const form = searchInput.closest('form');
                    form.submit();
                }, 500);
            });
        });
    </script>
    </body>
@endsection
