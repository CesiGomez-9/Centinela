<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informacion del Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background-color: #e6f0ff;">

<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/logo.jpg') }}" style="height:80px; margin-right: 10px;">
            Grupo Centinela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrate</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container bg-white p-5 rounded shadow mt-5 mb-5" style="max-width: 950px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-center mb-4" style="color: #09457f;">
            <i class="bi bi-people-fill me-2"></i>
            Informacion de los empleados
        </h3>
        <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Volver
        </a>
    </div>

    <form>
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-person-fill me-2"></i>Nombre:</label>
                <input type="text" class="form-control" value="{{ $empleado->nombre }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-person-fill me-2"></i>Apellido:</label>
                <input type="text" class="form-control" value="{{ $empleado->apellido }}" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-credit-card-2-front-fill me-2"></i>Identidad:</label>
                <input type="text" class="form-control" value="{{ $empleado->identidad }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-geo-alt-fill me-2"></i>Dirección:</label>
                <input type="text" class="form-control" value="{{ $empleado->direccion }}" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-envelope-fill me-2"></i>Email:</label>
                <input type="email" class="form-control" value="{{ $empleado->email }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-telephone-fill me-2"></i>Teléfono:</label>
                <input type="text" class="form-control" value="{{ $empleado->telefono }}" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-droplet-fill me-2"></i>Tipo de Sangre:</label>
                <input type="text" class="form-control" value="{{ $empleado->tipodesangre }}" readonly>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold"><i class="bi bi-exclamation-diamond-fill me-2"></i>Alergias:</label>
                <textarea class="form-control" rows="2" readonly>{{ $empleado->alergias }}</textarea>
            </div>
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>
                @isset($empleado)
                    Informacion del contacto de emergencia
                @else
                    Contacto de emergencia
                @endisset
            </h3>

            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-person-lines-fill me-2"></i>Contacto de Emergencia:</label>
                <input type="text" class="form-control" value="{{ $empleado->contactodeemergencia }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-telephone-plus-fill me-2"></i>Teléfono de Emergencia:</label>
                <input type="text" class="form-control" value="{{ $empleado->telefonodeemergencia }}" readonly>
            </div>

        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
