<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña | Grupo Centinela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f2c5c, #1b3e80);
        }

        .card-reset {
            width: 400px;
            padding: 3rem;
            background: rgba(17, 43, 82, 0.95);
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.6);
            color: #ffffff;
            text-align: center;
            position: relative;

        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-reset i {
            font-size: 4rem;
            color: #3b82f6;
            margin-bottom: 20px;
        }

        .card-reset h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .card-reset p {
            margin-bottom: 1.5rem;
            color: #cbd5e1;
        }

        .form-control {
            background: transparent !important; /* transparente como el correo */
            border: 1px solid #3b82f6;
            border-radius: 10px;
            color: #ffffff;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 8px rgba(96, 165, 250, 0.5);
            color: #ffffff;
            background: transparent !important;
        }

        .form-control::placeholder {
            color: #dbeafe;
            opacity: 1;
        }

        .btn-reset {
            width: 40%;
            height: 10%;
            background: #3b82f6;
            color: #ffffff;
            border: none;
            font-weight: bold;
            border-radius: 12px;
            font-size: 0.9rem; /* más pequeño */
            transition: 0.3s;
        }

        .btn-reset:hover {
            background: #2563eb;
        }

        .text-small {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 15px;
        }

        .alert {
            text-align: left;
        }
    </style>
</head>
<body>

<div class="card-reset">
    <i class="bi bi-key-fill"></i>
    <h2>Restablecer Contraseña</h2>
    <p>Introduce tu nueva contraseña</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Nueva contraseña" required maxlength="20">
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" required maxlength="20">
        </div>
        <button type="submit" class="btn btn-reset"> Restablecer</button>
    </form>

    <p class="text-small"><a href="{{ route('login') }}" style="color:#60a5fa;">Volver al login</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
