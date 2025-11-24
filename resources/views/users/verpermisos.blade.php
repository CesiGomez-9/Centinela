@extends('plantilla')
@section('content')

    <style>
        body {
            background-color: #BCD0E4FF; /* Fondo general azul */
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        .card {
            background-color: rgba(26, 35, 64, 0.95); /* Ventanita oscura */
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            margin: 40px auto;
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

        .user-info p {
            margin-bottom: 10px;
            border-left: 4px solid #cda34f;
            padding-left: 10px;
            color: #fff;
        }

        .user-info i {
            margin-right: 8px;
            color: #cda34f;
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .permission-card {
            background-color: #2a3357;
            border: 1px solid #cda34f;
            border-radius: 0.8rem;
            padding: 12px;
            text-align: center;
            transition: all 0.3s ease;
            color: #fff;
            font-weight: 500;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .permission-card:hover {
            background-color: #cda34f;
            color: #1a2340;
            cursor: pointer;
            transform: translateY(-2px);
        }

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

        @media (max-width: 767px) {
            .permissions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-shield-lock-fill me-2"></i> Roles y permisos del usuario
        </div>

        <div class="card-body">
            <div class="user-info">
                <p><i class="bi bi-person-fill"></i><strong>Nombre:</strong> {{ $user->empleado->nombre }} {{ $user->empleado->apellido }}</p>
                <p><i class="bi bi-envelope-fill"></i><strong>Correo:</strong> {{ $user->email }}</p>
                <p><i class="bi bi-person-badge-fill"></i><strong>Usuario:</strong> {{ $user->usuario }}</p>
                <p><i class="bi bi-shield-fill-check"></i><strong>Rol asignado:</strong> {{ $user->rol }}</p>
            </div>

            <div class="permissions-grid">
                @php
                    $permisos = [];
                    if($user->rol === 'Administrador') {
                        $permisos = ['Gestionar todos los módulos', 'Crear/Editar/Eliminar entidades', 'Ver reportes completos'];
                    } elseif($user->rol === 'Vigilante') {
                        $permisos = ['Registrar asistencia', 'Ver turnos asignados'];
                    } elseif($user->rol === 'Técnico') {
                        $permisos = ['Ver instalaciones asignadas', 'Registrar asistencia', 'Ver turnos'];
                    }
                @endphp

                @foreach($permisos as $permiso)
                    <div class="permission-card">{{ $permiso }}</div>
                @endforeach
            </div>

            <div class="btn-center">
                <a href="{{ route('users.index') }}" class="btn btn-return">
                    <i class="bi bi-arrow-left me-2"></i> Volver a la lista
                </a>
            </div>
        </div>
    </div>

@endsection
