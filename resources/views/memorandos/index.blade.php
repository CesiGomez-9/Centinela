@extends('plantilla')
@section('content')
    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-file-earmark-text me-2"></i>Lista de memorandum
            </h3>

            <form method="GET" action="{{ route('memorandos.index') }}">
                <div class="row mb-4 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                   placeholder="Buscar por empleado, autor y tipo"
                                   value="{{ request('search') }}">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex flex-column gap-2">
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

                    <div class="col-md-2 ms-3 d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('memorandos.index') }}" class="btn btn-sm btn-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i> Limpiar
                        </a>
                    </div>

                    <div class="col-md-3 ms-auto">
                        <a href="{{ route('memorandos.create') }}" class="btn btn-md btn-outline-primary w-100">
                            <i class="bi bi-pencil-square me-0"></i> Crear nuevo memorandum
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
                    <th>#</th>
                    <th>Empleado</th>
                    <th>Autor</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($memorandos as $memorando)
                    <tr>
                        <td>{{ $loop->iteration + ($memorandos->currentPage() - 1) * $memorandos->perPage() }}</td>
                        <td>{{ $memorando->destinatario->nombre ?? '---' }} {{ $memorando->destinatario->apellido ?? '' }}</td>
                        <td>{{ $memorando->autor->nombre ?? '---' }} {{ $memorando->autor->apellido ?? '' }}</td>
                        <td>{{ $memorando->titulo }}</td>
                        <td>{{ $memorando->tipo }}</td>
                        <td>{{ \Carbon\Carbon::parse($memorando->fecha)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('memorandos.show', $memorando->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="{{ route('memorandos.edit', $memorando->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay memorandums registrados.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @if(request('search') && $memorandos->total() > 0)
                <div class="mb-3 text-muted">
                    Mostrando {{ $memorandos->count() }} de {{ $memorandos->total() }} memorandums encontrados para
                    "<strong>{{ request('search') }}</strong>".
                </div>
            @elseif(request('search') && $memorandos->total() === 0)
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong>{{ request('search') }}</strong>".
                </div>
            @endif


            <div class="d-flex justify-content-center mt-4">
                {{ $memorandos->links('pagination::bootstrap-5') }}
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
