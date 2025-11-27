@extends('plantilla')
@section('content')
    <body style="background-color: #e6f0ff;">
    <style>
        .btn-outline-success-custom {
            color: #28a745;
            border: 1px solid #28a745;
            background-color: transparent;
            transition: all 0.2s ease-in-out;
        }

        .btn-outline-success-custom:hover,
        .btn-outline-success-custom:focus {
            background-color: #55ca6f;
            color: #155724;
            border-color: #28a745;
        }

        .live-search-table tbody tr {
            transition: all 0.2s ease;
        }
    </style>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">

            <div class="position-relative mb-4">

                <h3 class="text-center mb-0" style="color: #09457f;">
                    <i class="bi bi-people-fill me-2"></i>Lista de usuarios
                </h3>

                <a href="{{ route('users.create') }}"
                   class="btn btn-md btn-outline-primary position-absolute end-0 top-50 translate-middle-y">
                    <i class="bi bi-pencil-square me-1"></i> Registrar nuevo usuario
                </a>
            </div>

            <form method="GET" action="{{ route('users.index') }}">
                <div class="row mb-4 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchInput" name="search" class="form-control" placeholder="Buscar por nombre o usuario..." value="{{ request('search') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="position-relative">
                            <select id="rolFilter" name="rol" class="form-select ps-5">
                                <option value="">Tipo de roles...</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol }}" {{ request('rol') == $rol ? 'selected' : '' }}>{{ $rol }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-person-fill position-absolute top-50 start-0 translate-middle-y ms-2" style="pointer-events: none; color: #6c757d;"></i>
                        </div>
                    </div>

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

                    <div class="col-md-2 d-flex flex-column gap-2 align-items-start">
                        <button type="submit" class="btn btn-sm btn-primary w-75 px-2 py-1">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary w-75 px-2 py-1">
                            <i class="bi bi-x-circle me-1"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped live-search-table align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Creado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="usersTableBody">
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->empleado->nombre ?? $user->name }} {{ $user->empleado->apellido ?? $user->apellido }}</td>
                            <td>{{ $user->usuario ?? '—' }}</td>
                            <td>{{ $user->rol ?? '—' }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('roles_permisos.asignar', $user->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-fill"></i> Asignar rol
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div id="mensajeUsuariosBlade">
                    @php
                        $totalUsuarios = $users->total();
                        $usuariosMostrados = $users->count();
                        $rolFiltrado = request('rol');
                        $busqueda = request('search');
                        $fechaInicio = request('fecha_inicio');
                        $fechaFin = request('fecha_fin');
                    @endphp

                    @if($totalUsuarios > 0)
                        Mostrando {{ $usuariosMostrados }}
                        @if($rolFiltrado)
                            {{ strtolower($rolFiltrado) }}{{ $usuariosMostrados > 1 ? 's' : '' }}
                        @endif
                        de {{ $totalUsuarios }}
                        @if($rolFiltrado)
                            {{ strtolower($rolFiltrado) }}{{ $totalUsuarios > 1 ? 's' : '' }}
                        @else
                            usuario{{ $totalUsuarios > 1 ? 's' : '' }}
                        @endif

                        @php
                            $filtros = [];
                            if($busqueda) $filtros[] = 'Nombre/Usuario: "'.$busqueda.'"';
                            if($fechaInicio || $fechaFin) {
                                $fechas = [];
                                if($fechaInicio) $fechas[] = 'desde '.\Carbon\Carbon::parse($fechaInicio)->format('d/m/Y');
                                if($fechaFin) $fechas[] = 'hasta '.\Carbon\Carbon::parse($fechaFin)->format('d/m/Y');
                                $filtros[] = 'Fechas: '.implode(' ', $fechas);
                            }
                        @endphp

                        @if(count($filtros))
                            para "<strong>{{ implode(', ', $filtros) }}</strong>"
                        @endif
                    @else
                        <span class="text-danger">
                        No se encontraron usuarios
                        @if($busqueda) para "<strong>{{ $busqueda }}</strong>" @endif
                            @if($rolFiltrado) con rol "<strong>{{ $rolFiltrado }}</strong>" @endif
                            @if($fechaInicio || $fechaFin)
                                en fechas
                                @if($fechaInicio) desde <strong>{{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}</strong> @endif
                                @if($fechaFin) hasta <strong>{{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</strong> @endif
                            @endif.
                    </span>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const rolFilter = document.getElementById('rolFilter');
        const usersTableBody = document.getElementById('usersTableBody');
        const mensajeUsuariosDiv = document.getElementById('mensajeUsuariosBlade');

        function fetchUsers(query = '', rol = '') {
            const fechaInicio = document.querySelector('input[name="fecha_inicio"]').value;
            const fechaFin = document.querySelector('input[name="fecha_fin"]').value;

            const url = `{{ route('users.index') }}?search=${query}&rol=${rol}&fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`;

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTbody = doc.getElementById('usersTableBody');
                    if(newTbody) usersTableBody.innerHTML = newTbody.innerHTML;
                    const nuevoMensaje = doc.getElementById('mensajeUsuariosBlade');
                    if(nuevoMensaje) mensajeUsuariosDiv.innerHTML = nuevoMensaje.innerHTML;
                });
        }

        searchInput.addEventListener('input', function() {
            fetchUsers(this.value, rolFilter.value);
        });

        rolFilter.addEventListener('change', function() {
            fetchUsers(searchInput.value, this.value);
        });

        document.querySelectorAll('input[name="fecha_inicio"], input[name="fecha_fin"]').forEach(input => {
            input.addEventListener('change', () => {
                fetchUsers(searchInput.value, rolFilter.value);
            });
        });
    </script>
@endsection
