@extends('plantilla')

@section('content')
    <style>
        body {
            background-color: #BCD0E4FF;
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        .card {
            background-color: rgba(26, 35, 64, 0.95);
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            max-width: 800px;
            margin: 60px auto;
            padding: 25px;
            color: #fff;
        }

        .card-header {
            background-color: #cda34f;
            padding: 15px 20px;
            border-radius: 0.8rem 0.8rem 0 0;
            font-size: 1.3rem;
            font-weight: 600;
            text-align: center;
            color: #1a2340;
        }

        .card-body {
            padding: 20px;
        }

        .role-info p {
            margin-bottom: 15px;
            border-left: 4px solid #cda34f;
            padding-left: 12px;
            font-size: 1rem;
        }

        .role-info i {
            margin-right: 8px;
            color: #cda34f;
        }

        .permissions-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #cda34f;
            font-size: 1.05rem;
        }

        .module-title {
            font-weight: 500;
            margin: 10px 0 5px;
            color: #e0b44c;
            font-size: 0.95rem;
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px 12px;
            margin-top: 5px;
            max-height: 250px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .permission-chip {
            display: flex;
            align-items: center;
            gap: 4px;
            background-color: #2a3357;
            color: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            cursor: default;
            transition: none;
        }

        .permission-chip::before {
            content: '•';
            color: #cda34f;
            font-weight: bold;
            margin-right: 4px;
        }

        .permission-chip i {
            font-size: 0.9rem;
            color: #cda34f;
        }

        .btn-center {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-return, .btn-edit {
            background-color: #cda34f;
            color: #1a2340;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-return:hover, .btn-edit:hover {
            background-color: #0d1b2a;
            color: #fff;
        }

        .permissions-grid::-webkit-scrollbar {
            width: 6px;
        }

        .permissions-grid::-webkit-scrollbar-track {
            background: rgba(26, 35, 64, 0.3);
            border-radius: 3px;
        }

        .permissions-grid::-webkit-scrollbar-thumb {
            background-color: #cda34f;
            border-radius: 3px;
            border: 1px solid rgba(26, 35, 64, 0.5);
        }

        .permissions-grid::-webkit-scrollbar-thumb:hover {
            background-color: #e0b44c;
        }

        /* Mensaje de sin permisos en blanco */
        .no-permissions {
            color: #fff;
            font-style: italic;
        }

    </style>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-shield-lock-fill me-2"></i> Ver rol y permisos de {{ $role->name }}
        </div>

        <div class="card-body">
            <div class="role-info">
                <p><i class="bi bi-shield-fill-check"></i><strong>Nombre del rol:</strong> {{ $role->name }}</p>
                <p><i class="bi bi-calendar-fill"></i><strong>Creado:</strong> {{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y ') }}</p>
            </div>

            <div class="permissions-title">Permisos asignados</div>

            @forelse($permisosPorModulo as $modulo => $perms)
                <div class="module-title">{{ $modulo }}</div>
                <div class="permissions-grid">
                    @forelse($perms as $perm)
                        <div class="permission-chip">
                            <i class="bi bi-key-fill"></i> {{ ucfirst($perm->name) }}
                        </div>
                    @empty
                        <div class="permission-chip no-permissions">Sin permisos en este módulo</div>
                    @endforelse
                </div>
            @empty
                <p class="no-permissions">No hay permisos asignados al rol.</p>
            @endforelse

            <div class="btn-center">
                <a href="{{ route('roles_permisos.index') }}" class="btn-return">
                    <i class="bi bi-arrow-left me-2"></i> Volver
                </a>
                <a href="{{ route('roles_permisos.editar', $role->id) }}" class="btn-edit">
                    <i class="bi bi-pencil-square me-2"></i> Editar
                </a>
            </div>
        </div>
    </div>
@endsection
