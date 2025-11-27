@extends('plantilla')
@section('content')

    <style>
        .tabla-roles td {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }
        .bg-rol {
            background-color: #f0f8ff !important;
        }
    </style>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-shield-lock-fill me-2"></i>Lista de roles y permisos
            </h3>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('roles_permisos.index') }}" class="mb-4 row align-items-end">
                {{-- Buscador --}}
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre..."
                               value="{{ request('search') }}" id="searchInput">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                {{-- Select por rol --}}
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-shield-lock-fill me-1"></i> Rol</span>
                        <select name="rol" class="form-select" id="rolSelect">
                            <option value="">Todos...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ request('rol') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Botón Listado usuarios --}}
                <div class="col-md-4 d-flex justify-content-start">
                    <a href="{{ route('users.index') }}" class="btn btn-md btn-outline-primary">
                        <i class="bi bi-pencil-square me-2"></i> Listado usuarios
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
                <table class="table table-bordered table-striped tabla-roles align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr class="bg-rol">
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>{{ $user->empleado->nombre ?? $user->nombre }} {{ $user->empleado->apellido ?? '' }}</td>
                            <td>
                                @if($user->roles->isNotEmpty())
                                    {{ $user->roles->pluck('name')->implode(', ') }}
                                @else
                                    <span class="text-muted">Sin rol</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('roles_permisos.ver', $user->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye-fill"></i> Ver
                                </a>
                                <a href="{{ route('roles_permisos.editar', $user->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filtroForm = document.querySelector('form');
            const rolSelect = document.querySelector('#rolSelect');
            const searchInput = document.querySelector('#searchInput');

            // Filtrar automáticamente al cambiar rol
            rolSelect.addEventListener('change', function () {
                filtroForm.submit();
            });

            // Filtrar automáticamente al escribir en el buscador (espera 0.5s)
            let timeout = null;
            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filtroForm.submit();
                }, 500);
            });
        });
    </script>

@endsection
