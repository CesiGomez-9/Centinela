<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informacion del Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body style="background-color: #f8f4ec; font-family: 'Inter', sans-serif; font-size: 16px;">
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('centinela.jpg') }}" style="height:80px; margin-right: 10px;">
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

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show mt-3 mx-3" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif


<style>
    body {
        background-color: #f8f4ec;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        margin: 0;
        padding: 0;
    }

    .card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        background: #ffffff;
        max-width: 1100px;
        margin: 10px auto;
    }

    .card-header {
        background-color: #0a1f3a;
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid #cda34f;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .card-header h5 {
        color: #ffffff;
        font-weight: 600;
        font-size: 1.15rem;
        margin: 0;
    }

    .card-header small {
        color: #dcdcdc;
        font-size: 0.75rem;
    }

    .section-header {
        background-color: #0a1f3a;
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid #cda34f;
        text-align: center;
        margin-top: 0.5rem;
        border-radius: 0;
    }

    .section-header h5 {
        color: #ffffff;
        font-weight: 600;
        font-size: 1.15rem;
        margin: 0;
    }

    .card-body {
        padding: 0.8rem 1.2rem 0.5rem 1.2rem;
        font-size: 0.95rem;
    }

    .card-body p {
        margin-bottom: 0.5rem;
        border-left: 4px solid #cda34f;
        padding-left: 0.6rem;
    }

    .card-body i {
        color: #1b263b;
    }

    .card-body strong {
        color: #0d1b2a;
        font-weight: 600;
    }

    .card-footer {
        background-color: #0a1f3a;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        color: #f5f5f5;
        text-align: right;
        border-top: 1px solid #cda34f;
        margin-top: 15px;

    }

    .btn-return, .btn-edit {
        background-color: #cda34f;
        color: #ffffff;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        font-size: 0.95rem;
        margin: 0 0.5rem;
    }

    .btn-return:hover, .btn-edit:hover,
    .btn-return:focus, .btn-edit:focus {
        background-color: #0d1b2a;
        color: #ffffff;
    }

    @media (max-width: 767.98px) {
        .card-body {
            padding: 0.8rem;
            font-size: 0.9rem;
        }

        .btn-return, .btn-edit {
            display: block;
            width: 100%;
            margin: 0.5rem 0;
        }
    }

    .d-flex.align-items-center.gap-3 {
        margin-top: 1rem;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <div class="card">
                <div class="card-header position-relative">
                    <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i>Información del empleado</h5>
                    <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                        Creado: {{ $empleado->created_at ? $empleado->created_at->diffForHumans() : 'Fecha no disponible' }}
                    </small>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p><i class="bi bi-person-fill me-2"></i><strong>Nombre:</strong> {{ $empleado->nombre }}</p>
                            <p><i class="bi bi-person-fill me-2"></i><strong>Apellido:</strong> {{ $empleado->apellido }}</p>
                            <p><i class="bi bi-credit-card-2-front-fill me-2"></i><strong>Identidad:</strong> {{ $empleado->identidad }}</p>
                            <p><i class="bi bi-geo-alt-fill me-2"></i><strong>Departamento:</strong> {{ $empleado->departamento }}</p>
                            <p><i class="bi bi-geo-alt-fill me-2"></i><strong>Dirección:</strong> {{ $empleado->direccion }}</p>
                            <p><i class="bi bi-list me-2"></i><strong>Categoría:</strong> {{ $empleado->categoria }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="bi bi-envelope-fill me-2"></i><strong>Correo:</strong> {{ $empleado->email }}</p>
                            <p><i class="bi bi-telephone-fill me-2"></i><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>
                            <p><i class="bi bi-droplet-fill me-2"></i><strong>Tipo de sangre:</strong> {{ $empleado->tipodesangre }}</p>
                            <p><i class="bi bi-box-seam me-2"></i><strong>Productos requeridos:</strong></p>
                            @if(count($productos) > 0)
                                <ul class="mb-0 ps-4">
                                    @foreach($productos as $producto)
                                        <li>{{ $producto }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p><em>No hay productos específicos requeridos.</em></p>
                            @endif

                        </div>
                    </div>
                    <div class="section-header mt-4">
                        <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i>Contacto de emergencia</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="bi bi-person-lines-fill me-2"></i><strong>Nombre completo:</strong> {{ $empleado->contactodeemergencia }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="bi bi-telephone-plus-fill me-2"></i><strong>Teléfono:</strong> {{ $empleado->telefonodeemergencia }}</p>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <small>Última actualización: {{ $empleado->updated_at ? $empleado->updated_at->diffForHumans() : 'Fecha no disponible' }}</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                <a href="{{ route('empleados.index') }}" class="btn btn-return">
                    <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                </a>
                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-edit">
                    <i class="bi bi-pencil-square me-2"></i>Editar empleado
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
