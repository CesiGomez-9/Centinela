@extends('plantilla')
@section('content')
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    </head>

    <style>
        body {
            background-color: #e6f0ff;
            color: #000;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 750px;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 15px;
            background-color: #1a2340;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
            color: #fff;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            align-items: start;
            position: relative;
        }

        .grid-2::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 2px;
            background: linear-gradient(to bottom, #d4af37, #b8962e, #d4af37);
            opacity: 0.7;
            border-radius: 10px;
        }

        .columna {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: normal;
            color: #ffffff;
            text-align: left;
            margin-bottom: 5px;
        }


        .input-icon {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon i {
            position: absolute;
            left: 10px;
            color: #ccc;
            font-size: 1rem;
            pointer-events: none;
        }

        .input-icon input {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border-radius: 8px;
            border: none;
            background-color: #2a3357;
            color: #fff;
            font-size: 15px;
        }

        input[readonly] {
            background-color: #3a4467;
            cursor: not-allowed;
        }

        .botones {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn i {
            vertical-align: middle;
        }
    </style>

    <div class="container">
        <h1>
            Perfil del usuario
            <i class="bi bi-person-fill" style="font-size:2rem;"></i>
        </h1>

        <div class="grid-2">
            <div class="columna">
                <h5 style="color: #d4af37;">Datos del empleado</h5>
                <div>
                    <label>Empleado:</label>
                    <div class="input-icon">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" value="{{ $user->empleado->nombre ?? $user->name }} {{ $user->empleado->apellido ?? $user->apellido }}" readonly>
                    </div>
                </div>

                <div>
                    <label>Identidad:</label>
                    <div class="input-icon">
                        <i class="bi bi-card-list"></i>
                        <input type="text" value="{{ $user->empleado->identidad ?? '—' }}" readonly>
                    </div>
                </div>

                <div>
                    <label>Correo electrónico:</label>
                    <div class="input-icon">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" value="{{ $user->email }}" readonly>
                    </div>
                </div>
            </div>

            <div class="columna">
                <h5 style="color: #d4af37;">Datos para inicio de sesión</h5>

                <div>
                    <label>Usuario:</label>
                    <div class="input-icon">
                        <i class="bi bi-person-badge-fill"></i>
                        <input type="text" value="{{ $user->usuario }}" readonly>
                    </div>
                </div>

                <div>
                    <label>Rol:</label>
                    <div class="input-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                        <input type="text" value="{{ $user->rol }}" readonly>
                    </div>
                </div>

                <div>
                    <label>Fecha de creación:</label>
                    <div class="input-icon">
                        <i class="bi bi-calendar-fill"></i>
                        <input type="text" value="{{ $user->created_at->format('d/m/Y') }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="botones">
            <a href="{{ route('users.index') }}" class="btn w-30" style="background-color:#cda34f; color:#1a2340;">
                <i class="bi bi-arrow-left me-2"></i> Volver a la lista
            </a>
            <a href="{{ route('users.verpermisos', $user->id) }}" class="btn w-40" style="background-color:#cda34f; color:#1a2340;">
                <i class="bi bi-eye-fill me-2"></i> Ver permisos
            </a>
        </div>
    </div>
@endsection
