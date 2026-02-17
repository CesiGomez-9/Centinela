@extends("plantilla")

@section('content')

    <style>
        body{
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }

        .tabla-roles td {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }
        .bg-rol {
            background-color: #f0f8ff !important;
        }

        /* Estilo del input buscador */
        #rolInput {
            max-width: 100%;
        }
    </style>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-shield-lock-fill me-2"></i>Lista de roles
            </h3>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('roles_permisos.index') }}" class="mb-4 row align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input
                            type="text"
                            id="rolSearchInput"
                            name="rol"
                            value="{{ request('rol') }}"
                            class="form-control"
                            placeholder="Buscar por rol"
                            list="rolesList"
                            autocomplete="off"
                        >
                        <datalist id="rolesList">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"></option>
                            @endforeach
                        </datalist>
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
                {{-- Filtro por fecha --}}
                <div class="col-md-3 d-flex flex-column gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Desde</span>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Hasta</span>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                    </div>
                </div>

                {{-- Botón filtrar y limpiar --}}
                <div class="col-md-2 d-flex flex-column gap-2 align-items-start">
                    <button type="submit" class="btn btn-sm btn-primary px-2 py-1" style="font-size: 12px; width: 90px;">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('roles_permisos.index') }}" class="btn btn-sm btn-secondary px-2 py-1" style="font-size: 12px; width: 90px;">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>

                {{-- Botón volver / registrar --}}
                <div class="col-auto d-flex flex-column align-items-end">
                    <a href="{{ route('roles_permisos.asignar') }}" class="btn btn-md btn-outline-primary mb-4">
                        <i class="bi bi-arrow-left-circle me-2"></i> Registrar un nuevo rol
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
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre del rol</th>
                        <th>Creado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('roles_permisos.ver', $role->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('roles_permisos.editar', $role->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay roles creados</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(request('rol') || request('fecha_inicio') || request('fecha_fin'))
                <div class="mb-3 text-muted">
                    Mostrando {{ $roles->count() }} resultados filtrados.
                </div>
            @endif

            {{-- Paginación --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $roles->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rolInput = document.getElementById('rolSearchInput');
            if (!rolInput) return;

            let timer;
            rolInput.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    const form = rolInput.closest('form');
                    form.submit();
                }, 500); // delay de 500ms
            });

            // Mantener cursor al final del texto
            const length = rolInput.value.length;
            rolInput.setSelectionRange(length, length);
            rolInput.focus();
        });
    </script>

@endsection
