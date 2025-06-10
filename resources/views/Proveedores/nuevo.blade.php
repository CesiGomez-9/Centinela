@extends('plantilla')
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>¡Oops!</strong> Hay problemas con los datos ingresados:<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Proveedor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <style>
        body {
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }
        .form-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-light p-5 rounded shadow-lg position-relative">


                <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                    <i class="bi bi-building" style="font-size: 4rem;"></i>
                </div>

                <h3 class="text-center mb-4 style="style="color: #09457f;">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Registrar Proveedor
                </h3>

                <form action="{{ route('Proveedores.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="nombres" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                <input type="text" name="apellidos" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <input type="text" name="direccion" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" name="telefono" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="correo" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="identificacion" class="form-label">Identificación</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" name="identificacion" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="cargocontacto" class="form-label">Cargo del contacto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                <input type="text" name="cargocontacto" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="categoriarubro" class="form-label">Categoría o rubro</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                <select name="categoriarubro" class="form-select" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Cámaras de seguridad">Cámaras de seguridad</option>
                                    <option value="Alarmas antirrobo">Alarmas antirrobo</option>
                                    <option value="Cerraduras inteligentes">Cerraduras inteligentes</option>
                                    <option value="Sensores de movimiento">Sensores de movimiento</option>
                                    <option value="Luces con sensor de movimiento">Luces con sensor de movimiento</option>
                                    <option value="Rejas o puertas de seguridad">Rejas o puertas de seguridad</option>
                                    <option value="Sistema de monitoreo 24/7">Sistema de monitoreo 24/7</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('Proveedores.nuevo') }}" class="btn btn-warning"
                           onclick="return confirm('¿Estás seguro que deseas cancelar? Se perderán los cambios no guardados.');">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

@endsection

