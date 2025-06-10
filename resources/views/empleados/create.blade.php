<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #e6f0ff;"> <nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
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
<div class="container mt-5" style="max-width: 900px;">
    <div class="card shadow p-4" style="background-color: #ffffff;"> <h2 class="mb-4">Registro De Nuevo Empleado</h2>
        <div class="row mb-3">
            <div class="col-auto">
                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Ver Empleados</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="empleadoForm" action="{{ route('empleados.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nombres</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Apellidos</label>
                    <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Identidad</label>
                    <input type="text" name="identidad" class="form-control" value="{{ old('identidad') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Nombre del Contacto de Emergencia</label>
                    <input type="text" name="contactodeemergencia" class="form-control" value="{{ old('contactodeemergencia') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Teléfono de Emergencia</label>
                    <input type="text" name="telefonodeemergencia" class="form-control" value="{{ old('telefonodeemergencia') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tipo de Sangre</label>
                    <select name="tipodesangre" class="form-select">
                        <option value="">Seleccione...</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipodesangre') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Alergias (seleccione)</label><br>
                    @php
                        $tiposAlergia = ['Polvo', 'Polen', 'Medicamentos', 'Alimentos', 'Ninguno'];
                        $alergiasSeleccionadas = old('alergias', []);
                    @endphp
                    @foreach($tiposAlergia as $alergia)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="alergias[]" value="{{ $alergia }}"
                                {{ in_array($alergia, $alergiasSeleccionadas) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $alergia }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                    <button type="button" class="btn btn-danger" onclick="borrarFormulario()">Borrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container my-4">
    @yield('content')
</div>

<script>
    function borrarFormulario() {
        if (confirm('¿Deseas borrar todos los datos del empleado?')) {
            document.getElementById('empleadoForm').reset();
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


