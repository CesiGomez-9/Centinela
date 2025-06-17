<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body style="background-color: #e6f0ff;">

<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/logo.jpg') }}" style="height:80px; margin-right: 10px;" alt="Logo Grupo Centinela">
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
            <i class="bi bi-person-badge-fill me-2"></i>Editar Empleado
        </h3>
        <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('empleados.update', $empleado->id) }}" method="POST" onsubmit="return validarFormulario()">
        @csrf
        @method('PUT')
        <div class="row g-4">

            <div class="col-md-4">
                <label class="form-label">Nombre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" class="form-control">
                    <div class="invalid-feedback" id="error-nombre"></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Apellido</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $empleado->apellido) }}" class="form-control">
                <div class="invalid-feedback" id="error-apellido"></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Identidad</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                    <input type="text" id="identidad" name="identidad" value="{{ old('identidad', $empleado->identidad) }}" class="form-control" oninput="formatearIdentidad(this)">
                <div class="invalid-feedback" id="error-identidad"></div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Dirección</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <input type="text" id="direccion" name="direccion" maxlength="25" class="form-control" value="{{ $empleado->direccion }}" oninput="validarTexto(this,25)" />
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}" class="form-control">
                    <div class="invalid-feedback" id="error-direccion"></div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" id="email" name="email" value="{{ old('email', $empleado->email) }}" class="form-control" oninput="validarCorreo(this, 50)">
                    <div class="invalid-feedback" id="error-email"></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Teléfono</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $empleado->telefono) }}" class="form-control" maxlength="8" oninput="formatearTelefono(this)">
                    <div class="invalid-feedback" id="error-telefono"></div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tipo de sangre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-droplet-fill"></i></span>
                    <select id="tipodesangre" name="tipodesangre" class="form-select">
                        <option value="">Seleccione...</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipodesangre', $empleado->tipodesangre) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="invalid-feedback" id="error-tipodesangre"></div>
            </div>

            <div class="col-md-10">
                <label class="form-label">
                    <i class="bi bi-exclamation-diamond-fill me-2"></i>
                    Alergias (seleccione):
                </label>
                @php
                    $tiposAlergia = ['Polvo', 'Polen', 'Medicamentos', 'Alimentos', 'Ninguno', 'Otros'];
                    $alergiasEmpleado = json_decode($empleado->alergias) ?? [];
                @endphp
                @foreach($tiposAlergia as $alergia)
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input alergia-checkbox"
                            type="checkbox"
                            value="{{ $alergia }}"
                            name="alergias[]"
                            {{ in_array($alergia, $alergiasEmpleado) ? 'checked' : '' }}
                        />
                        <label class="form-check-label">{{ $alergia }}</label>
                    </div>
                @endforeach
                <input type="text" id="alergiaOtros" name="alergiaOtros" value="{{ old('alergiaOtros', in_array('Otros', $alergiasEmpleado) ? $empleado->alergia_otros : '') }}" class="form-control mt-2" placeholder="Especifique si es Otros" style="display: none;">
                <div class="invalid-feedback" id="error-alergia"></div>
            </div>

            <h3 class="text-center mt-4 mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>Información del contacto de emergencia
            </h3>

            <div class="col-md-4">
                <label class="form-label">Nombre completo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                    <input type="text" id="contactoEmergencia" name="contactoEmergencia" value="{{ old('contactoEmergencia', $empleado->contactoEmergencia) }}" class="form-control">
                    <div class="invalid-feedback" id="error-contacto"></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Teléfono</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefonodeemergencia" name="telefonodeemergencia" value="{{ old('telefonodeemergencia', $empleado->telefonodeemergencia) }}" class="form-control" maxlength="8" oninput="formatearTelefono(this)">
                </div>
                <div class="invalid-feedback" id="error-telefonoEmergencia"></div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save-fill me-2"></i> Guardar Cambios
                </button>
                <a href="{{ route('empleados.index') }}" class="btn btn-danger"
                   onclick="return confirm('¿Estás seguro que deseas cancelar? Se perderán los cambios no guardados.');">
                    <i class="bi bi-x-circle me-2"></i> Cancelar
                </a>
            </div>

        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alergiaOtrosInput = document.getElementById('alergiaOtros');
        const otrosCheckbox = document.querySelector('.alergia-checkbox[value="Otros"]');

        function toggleAlergiaOtros() {
            if (otrosCheckbox.checked) {
                alergiaOtrosInput.style.display = 'block';
            } else {
                alergiaOtrosInput.style.display = 'none';
                alergiaOtrosInput.value = '';
                alergiaOtrosInput.classList.remove('is-invalid');
                document.getElementById('error-alergia').textContent = '';
            }
        }

        // Ejecutar esto después de un pequeño delay para asegurar que el checkbox está en el DOM
        setTimeout(toggleAlergiaOtros, 0);

        document.querySelectorAll('.alergia-checkbox').forEach(chk => {
            chk.addEventListener('change', toggleAlergiaOtros);
        });
    });

        ['telefono', 'telefonodeemergencia'].forEach(id => {
            const input = document.getElementById(id);
            input.addEventListener('keydown', e => {
                if ((input.selectionStart === 0 || input.value.length === 0) && e.key === '0') {
                    e.preventDefault();
                }
        });
    });

    function limpiarErrores() {
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    function validarTexto(input, maxLength) {
        let val = input.value;
        val = val.replace(/[^A-Za-z ]/g, '');
        while (val.includes('  ')) {
            val = val.replace(/  /g, ' ');
        }
        val = val.slice(0, maxLength);
        input.value = val;
    }

    function formatearIdentidad(input) {

        let val = input.value.replace(/[^0-9]/g, '');
        let cerosInicio = val.match(/^0*/)[0].length;

        if (cerosInicio > 4) {
            val = val.slice(0, -1);
        }
        val = val.slice(0, 15);
        if (val.length > 8) {
            input.value = val.slice(0, 4) + '-' + val.slice(4, 8) + '-' + val.slice(8);
        } else if (val.length > 4) {
            input.value = val.slice(0, 4) + '-' + val.slice(4);
        } else {
            input.value = val;
        }
    }

    function formatearTelefono(input) {
        let val = input.value.replace(/[^0-9]/g, '').slice(0, 8);
        let formatted = '';
        for (let i = 0; i < val.length; i++) {
            if (i > 0 && i % 2 === 0) formatted += '-';
            formatted += val[i];
        }
        input.value = formatted;
    }

    function validarCorreo(input, maxLength) {
        let val = input.value;
        val = val.replace(/[^a-zA-Z0-9@._\-]/g, '').slice(0, maxLength);
        input.value = val;
    }

    function validarFormulario() {
        limpiarErrores();
        let valido = true;

        const campos = [
            {id: 'nombre', msg: 'Debe ingresar nombres'},
            {id: 'apellido', msg: 'Debe ingresar apellidos'},
            {id: 'identidad', msg: 'Debe ingresar identidad'},
            {id: 'direccion', msg: 'Debe ingresar dirección'},
            {id: 'email', msg: 'Debe ingresar correo electrónico'},
            {id: 'telefono', msg: 'Debe ingresar teléfono'},
            {id: 'contactoEmergencia', msg: 'Debe ingresar nombre'},
            {id: 'telefonodeemergencia', msg: 'Debe ingresar teléfono'},
            {id: 'tipodesangre', msg: 'Debe seleccionar tipo de sangre'}
        ];

        campos.forEach(campo => {
            const input = document.getElementById(campo.id);
            if (!input.value.trim()) {
                valido = false;
                input.classList.add('is-invalid');
                let errorId = `error-${campo.id}`;

                if (campo.id === 'contactoEmergencia') errorId = 'error-contacto';
                if (campo.id === 'telefonodeemergencia') errorId = 'error-telefonoEmergencia';

                const errorElement = document.getElementById(errorId);
                if (errorElement) {
                    errorElement.textContent = campo.msg;
                }
            }
        });

        const identidad = document.getElementById('identidad').value;
        const identidadRegex = /^\d{4}-\d{4}-\d{5}$/;
        if (identidad && !identidadRegex.test(identidad)) {
            valido = false;
            const identidadInput = document.getElementById('identidad');
            identidadInput.classList.add('is-invalid');
            document.getElementById('error-identidad').textContent = 'Formato de identidad inválido (0000-0000-00000)';
        }

        const tipoSangre = document.getElementById('tipodesangre');
        if (!tipoSangre.value) {
            valido = false;
            tipoSangre.classList.add('is-invalid');
            document.getElementById('error-tipodesangre').textContent = 'Seleccione un tipo de sangre';
        }

        const checkboxes = document.querySelectorAll('.alergia-checkbox');
        const algunaSeleccionada = Array.from(checkboxes).some(chk => chk.checked);
        if (!algunaSeleccionada) {
            valido = false;
            document.getElementById('error-alergia').textContent = 'Debe seleccionar al menos una alergia';
        } else {
            if (document.querySelector('.alergia-checkbox[value="Otros"]').checked) {
                const otros = document.getElementById('alergiaOtros');
                if (!otros.value.trim()) {
                    valido = false;
                    otros.classList.add('is-invalid');
                    document.getElementById('error-alergia').textContent = 'Debe especificar la alergia';
                }
            }
        }

        return valido;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const telefonoInput = document.getElementById('telefono');
        telefonoInput.addEventListener('keydown', function(e) {
            if ((this.selectionStart === 0 || this.value.length === 0)) {
                if (!['9', '8', '2', '3'].includes(e.key)) {
                    e.preventDefault();
                }
            }
        });
        telefonoInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                const primerDigito = this.value.charAt(0);
                if (!['9', '8', '2', '3'].includes(primerDigito)) {
                    this.value = '';
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        ['telefono', 'telefonodeemergencia'].forEach(id => {
            const input = document.getElementById(id);
            input.addEventListener('keydown', function(e) {
                if ((this.selectionStart === 0 || this.value.length === 0)) {
                    if (!['9', '8', '2', '3'].includes(e.key)) {
                        e.preventDefault();
                    }
                }
            });
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    const primerDigito = this.value.charAt(0);
                    if (!['9', '8', '2', '3'].includes(primerDigito)) {
                        this.value = '';
                    }
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

