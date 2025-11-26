@extends('plantilla')
@section('content')
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

        /* Campos y botones uniformes */
        .date-filter input,
        .date-filter button,
        .date-filter a {
            min-width: 150px;
            font-size: 12px;
        }

        .date-filter .d-flex {
            gap: 5px;
        }
    </style>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>
                Lista de usuarios
            </h3>

            @php
                $hoy = date('Y-m-d');
                $maxFecha = date('Y-m-d', strtotime('+2 months'));
            @endphp

            <form method="GET" action="{{ route('users.index') }}">
                <div class="row mb-4 align-items-center">
                    <!-- Buscador -->
                    <div class="col-md-4 d-flex justify-content-start">
                        <div class="w-100">
                            <div class="input-group">
                                <input
                                    type="text"
                                    id="searchInput"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Buscar por nombre o usuario..."
                                    autocomplete="off"
                                />
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Filtro por fecha centrado -->
                    <div class="col-md-4 date-filter d-flex flex-column align-items-center">
                        <div class="d-flex mb-2 justify-content-center">
                            <input type="date" name="fecha_inicio" class="form-control form-control-sm"
                                   value="{{ request('fecha_inicio', $hoy) }}" min="{{ $hoy }}" max="{{ $maxFecha }}">
                            <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                        </div>
                        <div class="d-flex justify-content-center">
                            <input type="date" name="fecha_fin" class="form-control form-control-sm"
                                   value="{{ request('fecha_fin', $hoy) }}" min="{{ $hoy }}" max="{{ $maxFecha }}">
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">Limpiar</a>
                        </div>
                    </div>

                    <!-- Registrar nuevo usuario -->
                    <div class="col-md-4 d-flex justify-content-end">
                        <a href="{{ route('users.create') }}" class="btn btn-md btn-outline-primary">
                            <i class="bi bi-pencil-square me-2"></i> Registrar nuevo usuario
                        </a>
                    </div>
                </div>
            </form>

            @if(session('mensaje'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('mensaje') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                     <th>Creado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                            {{ $user->empleado->nombre ?? $user->name }} {{ $user->empleado->apellido ?? $user->apellido }}
                        </td>
                        <td>{{ $user->usuario ?? '—' }}</td>
                         <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="{{ route('roles.asignar', $user->id) }}"
                               class="btn btn-sm btn-warning">
                                Asignar Rol
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

            @if(request('search') && $users->total() > 0)
                <div class="mb-3 text-muted">
                    Mostrando {{ $users->count() }} de {{ $users->total() }} usuarios encontrados para
                    "<strong>{{ request('search') }}</strong>".
                </div>
            @elseif(request('search') && $users->total() === 0)
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong>{{ request('search') }}</strong>".
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
