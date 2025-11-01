@extends('plantilla')
@section('content')
    <style>
        .tabla-incapacidades td {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }

        .incapacidad-finalizada {
            background-color: #ffe6e6 !important;
        }
    </style>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-file-earmark-medical me-2"></i>Lista de incapacidades
            </h3>

            <form method="GET" action="{{ route('incapacidades.index') }}" id="filtroForm" class="mb-4 row align-items-end">

                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Buscar empleado..."
                               value="{{ request('search') }}">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Estado</span>
                        <select name="estado" id="estadoSelect" class="form-select">
                            <option value="">Todos...</option>
                            <option value="vigente" {{ request('estado') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                            <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 d-flex flex-column gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Desde</span>
                        <input type="date" name="fecha_inicio" class="form-control"
                               value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Hasta</span>
                        <input type="date" name="fecha_fin" class="form-control"
                               value="{{ request('fecha_fin') }}">
                    </div>
                </div>

                <div class="col-md-2 d-flex flex-column gap-2 align-items-start">
                    <button type="submit" class="btn btn-sm btn-primary px-2 py-1">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('incapacidades.index') }}" class="btn btn-sm btn-secondary px-2 py-1">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>

                <div class="col-md-2 ms-auto">
                    <a href="{{ route('incapacidades.create') }}" class="btn btn-md btn-outline-primary w-100">
                        <i class="bi bi-pencil-square me-1"></i> Registrar incapacidad
                    </a>
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
                <table class="table table-bordered table-striped tabla-incapacidades align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Empleado</th>
                        <th>Motivo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($incapacidades as $incapacidad)
                        @php
                            $hoy = now()->toDateString();
                            $estado = ($incapacidad->fecha_fin < $hoy) ? 'Finalizado' : 'Vigente';
                        @endphp
                        <tr class="{{ $estado == 'Finalizado' ? 'incapacidad-finalizada' : '' }}">
                            <td>{{ $loop->iteration + ($incapacidades->currentPage() - 1) * $incapacidades->perPage() }}</td>
                            <td>{{ $incapacidad->empleado->nombre }} {{ $incapacidad->empleado->apellido }}</td>
                            <td>{{ $incapacidad->motivo }}</td>
                            <td>{{ \Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($incapacidad->fecha_fin)->format('d/m/Y') }}</td>
                            <td class="text-center">
                            <span class="badge {{ $estado == 'Vigente' ? 'bg-success' : 'bg-danger' }}">
                                {{ $estado }}
                            </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('incapacidades.show', $incapacidad->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('incapacidades.edit', $incapacidad->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay incapacidades registradas.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                @php
                    $filtrosAplicados = request()->filled('search') || request()->filled('estado') || request()->filled('fecha_inicio') || request()->filled('fecha_fin');
                @endphp

                @if($filtrosAplicados && $incapacidades->total() > 0)
                    <div class="mb-3 text-muted">
                        Mostrando {{ $incapacidades->count() }} de {{ $incapacidades->total() }} incapacidades encontradas
                        @if(request('search') || request('estado') || request('fecha_inicio') || request('fecha_fin'))
                            para
                            @php
                                $filtros = [];
                                if(request('search')) $filtros[] = 'Empleado: "'.request('search').'"';
                                if(request('estado')) $filtros[] = 'Estado: "'.ucfirst(request('estado')).'"';
                                if(request('fecha_inicio') || request('fecha_fin')) {
                                    $fechas = [];
                                    if(request('fecha_inicio')) $fechas[] = 'desde '.\Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y');
                                    if(request('fecha_fin')) $fechas[] = 'hasta '.\Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y');
                                    $filtros[] = 'Fechas: '.implode(' ', $fechas);
                                }
                            @endphp
                            "<strong>{{ implode(', ', $filtros) }}</strong>"
                        @endif
                    </div>
                @elseif($filtrosAplicados && $incapacidades->total() === 0)
                    <div class="mb-3 text-danger">
                        No se encontraron resultados
                        @if(request('search')) para "<strong>{{ request('search') }}</strong>" @endif
                        @if(request('estado')) con estado "<strong>{{ ucfirst(request('estado')) }}</strong>" @endif
                        @if(request('fecha_inicio') || request('fecha_fin')) en fechas
                        @if(request('fecha_inicio')) desde <strong>{{ \Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y') }}</strong> @endif
                        @if(request('fecha_fin')) hasta <strong>{{ \Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y') }}</strong> @endif
                        @endif.
                    </div>
                @endif

            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $incapacidades->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const estadoSelect = document.getElementById('estadoSelect');
            const filtroForm = document.getElementById('filtroForm');

            if (searchInput) {
                searchInput.focus();
                const length = searchInput.value.length;
                searchInput.setSelectionRange(length, length);

                let timer;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        filtroForm.submit();
                    }, 500);
                });
            }

            if (estadoSelect) {
                estadoSelect.addEventListener('change', function () {
                    filtroForm.submit();
                });
            }
        });
    </script>
    </body>
@endsection

