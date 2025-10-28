@extends("plantilla")

@section('content')

    <style>
        body{
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }
    </style>

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

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>
                Lista de incidencias
            </h3>

            <form method="GET" action="{{ route('incidencias.index') }}">
                <div class="row mb-4 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Buscar por reportado, tipo, cliente, estado"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex flex-column gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Desde</span>
                            <input type="date" name="fecha_inicio" class="form-control"
                                   style="min-width: 140px;"
                                   value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Hasta</span>
                            <input type="date" name="fecha_fin" class="form-control"
                                   style="min-width: 140px;"
                                   value="{{ request('fecha_fin') }}">
                        </div>
                    </div>


                    <div class="col-md-2 d-flex flex-column gap-2 align-items-start">
                        <button type="submit" class="btn btn-sm btn-primary px-2 py-1" style="font-size: 12px; width: 90px;">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('incidencias.index') }}" class="btn btn-sm btn-secondary px-2 py-1" style="font-size: 12px; width: 90px;">
                            <i class="bi bi-x-circle me-1"></i> Limpiar
                        </a>
                    </div>


                    <div class="col-auto d-flex flex-column align-items-end">
                        <a href="{{ route('incidencias.formulario') }}" class="btn btn-sm btn-outline-primary mb-2">
                            <i class="bi bi-pencil-square me-2" ></i>Registrar una nueva incidencia
                        </a>

                        <a href="{{ route('incidencias.reporte', [
        'search' => request('search'),
        'fecha_inicio' => request('fecha_inicio'),
        'fecha_fin' => request('fecha_fin'),
        'cliente' => request('cliente'),
        'reportado_por' => request('reportado_por'),
        'tipo' => request('tipo'),
        'estado' => request('estado'),
    ]) }}"
                           class="btn btn-sm text-white mb-2"
                           style="background-color: #bfa046;">
                            <i class="bi bi-file-earmark-text me-2"></i> Generar reporte de incidencias
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

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Reportado por</th>
                    <th>Tipo</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($incidencias as $incidencia)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $incidencia->reportadoPorEmpleado->nombre ?? '---'}}</td>
                        <td>{{ $incidencia->tipo }}</td>
                        <td>{{ $incidencia->cliente->nombre ?? '---' }} </td>
                        <td>{{$incidencia->estado }}</td>
                        <td>{{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('incidencias.detalle', $incidencia->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="bi bi-pencil-square"></i>Editar
                            </a>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay incidencias registradas.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if(request('search') && $incidencias->total() > 0)
                <div class="mb-3 text-muted">
                    Mostrando {{ $incidencias->count() }} de {{ $incidencias->total() }} resultados encontrados para
                    "<strong>{{ request('search') }}</strong>".
                </div>
            @elseif(request('search') && $incidencias->total() === 0)
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong>{{ request('search') }}</strong>".
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $incidencias->links('pagination::bootstrap-5') }}
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

@endsection
