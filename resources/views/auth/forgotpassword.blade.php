<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | Grupo Centinela</title>
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
            position: relative;
            background: linear-gradient(135deg, #0f2c5c, #1b3e80);
        }

        body::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 900px;
            height: 700px;
            background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);
            z-index: 0;
        }

        .card-reset {
            width: 400px;
            padding: 3rem;
            background: #112b52;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.5);
            color: #ffffff;
            text-align: center;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
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
            background: transparent !important;
            border: 1px solid #3b82f6;
            border-radius: 10px;
            color: #ffffff;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59,130,246,0.5);
            color: #ffffff;
        }

        .btn-reset {
            width: 100%;
            background: #3b82f6;
            color: #ffffff;
            border: none;
            font-weight: bold;
            padding: 0.8rem;
            border-radius: 12px;
            font-size: 1rem;
            transition: 0.3s;
        }

        .btn-reset:hover {
            background: #1e40af;
        }

        .form-control::placeholder {
            color: #ffffff;
            opacity: 1;
        }

        .text-small {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 15px;
        }
    </style>
</head>
<body>



<div class="card-reset">
    <i class="bi bi-shield-lock-fill" style="font-size:4rem;color:#3b82f6;margin-bottom:20px;"></i>
    <h2>Recuperar Contraseña</h2>
    <p>Ingresa tu correo registrado</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
        </div>
        <button type="submit" class="btn btn-reset"><i class="bi bi-envelope-fill"></i> Enviar enlace</button>
    </form>

    <p class="text-small"><a href="{{ route('login') }}" style="color:#3b82f6;">Volver al login</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
