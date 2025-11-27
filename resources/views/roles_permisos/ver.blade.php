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

        /* Grid de permisos en 3 columnas con scroll */
        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px 12px;
            margin-top: 10px;
            max-height: 250px; /* Altura fija con scroll */
            overflow-y: auto;
            padding-right: 5px;
        }

        /* Permisos tipo chip/burbuja */
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

        /* Punto dorado delante del permiso */
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

        /* Botón regresar */
        .btn-center {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        .btn-return {
            background-color: #cda34f;
            color: #1a2340;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }

        .btn-return:hover {
            background-color: #0d1b2a;
            color: #fff;
        }
        .permissions-grid::-webkit-scrollbar {
            width: 6px;
        }

        .permissions-grid::-webkit-scrollbar-track {
            background: rgba(26, 35, 64, 0.3); /* color de fondo del track */
            border-radius: 3px;
        }

        .permissions-grid::-webkit-scrollbar-thumb {
            background-color: #cda34f; /* color dorado del thumb */
            border-radius: 3px;
            border: 1px solid rgba(26, 35, 64, 0.5); /* borde suave */
        }

        .permissions-grid::-webkit-scrollbar-thumb:hover {
            background-color: #e0b44c; /* dorado más claro al pasar mouse */
        }

    </style>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-shield-lock-fill me-2"></i> Ver rol y permisos de {{ $user->empleado->nombre }} {{ $user->empleado->apellido }}
        </div>

        <div class="card-body">
            <div class="role-info">
                <p><i class="bi bi-shield-fill-check"></i><strong>Rol asignado:</strong> {{ $user->roles->first()->name ?? 'Sin rol asignado' }}</p>
            </div>

            <div class="permissions-title">Permisos asignados</div>
            <div class="permissions-grid">
                @forelse($userPermissions as $perm)
                    <div class="permission-chip">
                        <i class="bi bi-key-fill"></i> {{ ucfirst($perm->name) }}
                    </div>
                @empty
                    <p class="text-muted">No hay permisos asignados.</p>
                @endforelse
            </div>

            <div class="btn-center">
                <a href="{{ route('roles_permisos.index') }}" class="btn btn-return">
                    <i class="bi bi-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>

@endsection
