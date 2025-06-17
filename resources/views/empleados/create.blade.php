<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .error-msg {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body style="background-color: #e6f0ff;">
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding: 1.2rem; font-family: 'Courier New', monospace;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('seguridad/logo.jpg') }}" style="height:80px; margin-right: 10px;" />
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
    <div class="card shadow p-4" style="background-color: #fff;">
        <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
            <i class="bi bi-person-badge" style="font-size: 4rem;"></i>
        </div>

        <h3 class="text-center mb-4" style="color: #09457f;">
            <i class="bi bi-people-fill me-2"></i>
            @isset($empleado)
                Editar empleado
            @else
                Registrar nuevo empleado
            @endisset
        </h3>

        @if(session('guardado') || (isset($guardado) && $guardado))
            <div class="alert alert-success">
                ¡Datos del empleado guardados correctamente!
            </div>
        @endif



        <form id="empleadoForm" method="POST" action="{{ route('empleados.store') }}" onsubmit="return validarFormulario()">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" id="nombre" name="nombre" maxlength="25" class="form-control" value="{{ old('nombre') }}" oninput="validarTexto(this,25)" />
                        <div class="invalid-feedback" id="error-nombre"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Apellido</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" id="apellido" name="apellido" maxlength="25" class="form-control" value="{{ old('apellido') }}" oninput="validarTexto(this,25)" />
                    </div>
                    <div class="error-msg" id="error-apellido"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Identidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                        <input type="text" id="identidad" name="identidad" maxlength="15" class="form-control" value="{{ old('identidad') }}" oninput="formatearIdentidad(this, 15)" />
                    </div>
                    <div class="error-msg" id="error-identidad"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                        <input type="text" id="direccion" name="direccion" maxlength="25" class="form-control" value="{{ old('direccion') }}" oninput="validarTexto(this,25)" />
                    </div>
                    <div class="error-msg" id="error-direccion"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" id="email" name="email" maxlength="20" class="form-control" value="{{ old('email') }}" oninput="validarCorreo(this,20)" />
                    </div>
                    <div class="error-msg" id="error-email"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                        <input type="text" id="telefono" name="telefono" maxlength="11" class="form-control" value="{{ old('telefono') }}" oninput="formatearTelefono(this)" />
                    </div>
                    <div class="error-msg" id="error-telefono"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de sangre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-droplet-fill"></i></span>
                        <select id="tipodesangre" name="tipodesangre" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipodesangre') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="error-msg" id="error-tipodesangre"></div>
                </div>
                <div class="col-md-10">
                    <label class="form-label">Alergias (seleccione)</label><br />
                    @php
                        $tiposAlergia = ['Polvo', 'Polen', 'Medicamentos', 'Alimentos', 'Ninguno', 'Otros'];
                        $oldAlergias = old('alergias', []);
                    @endphp
                    @foreach($tiposAlergia as $alergia)
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input alergia-checkbox"
                                type="checkbox"
                                value="{{ $alergia }}"
                                name="alergias[]"
                                {{ in_array($alergia, $oldAlergias) ? 'checked' : '' }}
                            />
                            <label class="form-check-label">{{ $alergia }}</label>
                        </div>
                    @endforeach
                    <input
                        type="text"
                        id="alergiaOtros"
                        name="alergiaOtros"
                        maxlength="50"
                        class="form-control mt-2"
                        style="{{ in_array('Otros', $oldAlergias) ? 'display:block;' : 'display:none;' }}"
                        placeholder="Especifique alergia"
                        value="{{ old('alergiaOtros') }}"
                        oninput="validarTexto(this,50)"
                    />
                    <div class="error-msg" id="error-alergia"></div>
                </div>


                <h3 class="text-center mb-4" style="color: #09457f;">
                    <i class="bi bi-people-fill me-2"></i>
                    @isset($empleado)
                        Editar empleado
                    @else
                        Contacto de emergencia
                    @endisset
                </h3>

                <div class="col-md-4">
                    <label class="form-label">Nombre y Apellido</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                        <input type="text" id="contactoEmergencia" name="contactodeemergencia" maxlength="25" class="form-control" value="{{ old('contactodeemergencia') }}" oninput="validarTexto(this,25)" />
                    </div>
                    <div class="error-msg" id="error-contacto"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                        <input type="text" id="telefonodeemergencia" name="telefonodeemergencia" maxlength="11" class="form-control" value="{{ old('telefonodeemergencia') }}" oninput="formatearTelefono(this)" />
                    </div>
                    <div class="error-msg" id="error-telefonoEmergencia"></div>
                </div>


                <div class="text-center mt-5">
                    <a href="{{ route('empleados.index') }}" class="btn btn-danger"
                       onclick="return confirm('¿Estás seguro que deseas cancelar? Se perderán los cambios no guardados.');">
                        <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                    <!-- Botón Limpiar -->
                    <button type="button" class="btn btn-danger" onclick="limpiarFormulario()">
                        <i class="bi bi-eraser-fill me-2"></i> Limpiar
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save-fill me-2"></i> Guardar
                    </button>
                    </div>
            </div>

        </form>
    </div>

    @if(isset($guardado) && $guardado && isset($empleados))
        <div class="card shadow p-4 mt-4" style="background-color: #fff;">
            <h3>Empleados registrados</h3>
            <ul class="list-group">
                @foreach($empleados as $emp)
                    <li class="list-group-item">
                        <strong>{{ $emp->nombre }} {{ $emp->apellido }}</strong> — Identidad: {{ $emp->identidad }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<script>


    function cancelarFormulario() {
        if (confirm("¿Estás seguro que deseas cancelar? Se perderán los datos ingresados.")) {
            document.getElementById('empleadoForm').reset();
        }
    }
    document.addEventListener("DOMContentLoaded", function () {
        const resetBtn = document.querySelector('button[type="reset"]');

        if (resetBtn) {
            resetBtn.addEventListener('click', function (e) {
                e.preventDefault();

                const form = this.closest('form');
                if (!form) return;

                form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(el => {
                    el.value = '';
                });

                form.querySelectorAll('select').forEach(el => {
                    el.selectedIndex = 0;
                });
                form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                    el.classList.remove('is-valid', 'is-invalid');
                });
                form.querySelectorAll('.text-danger').forEach(el => {
                    el.innerText = '';
                });
            });
        }
    });


    function evitarPrimerCero(inputId) {
        const input = document.getElementById(inputId);
        input.addEventListener('keydown', function(e) {
            if ((this.selectionStart === 0 || this.value.length === 0) && e.key === '0') {
                e.preventDefault();
            }
        });
    }
    evitarPrimerCero('telefono');
    evitarPrimerCero('telefonodeemergencia');


    function limpiarErrores() {
        document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');
    }


    function validarTexto(input, maxLength) {
        let val = input.value;

        // Permitir solo letras y espacios
        val = val.replace(/[^A-Za-z ]/g, '');

        // Bloquear espacios dobles seguidos
        while (val.includes('  ')) {
            val = val.replace(/  /g, ' ');
        }

        // Limitar longitud
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
        let val = input.value.replace(/[^0-9]/g, '').slice(0,8);
        let formatted = '';
        for(let i=0; i<val.length; i++) {
            if(i > 0 && i % 2 === 0) formatted += '-';
            formatted += val[i];
        }
        input.value = formatted;
    }
    function validarCorreo(input, maxLength) {
        let val = input.value;
        val = val.replace(/[^a-zA-Z0-9@._\-]/g, '').slice(0, maxLength);
        input.value = val;
    }

    const checkboxes = document.querySelectorAll('.alergia-checkbox');
    const alergiaOtrosInput = document.getElementById('alergiaOtros');
    checkboxes.forEach(chk => {
        chk.addEventListener('change', () => {
            if (document.querySelector('.alergia-checkbox[value="Otros"]').checked) {
                alergiaOtrosInput.style.display = 'block';
            } else {
                alergiaOtrosInput.style.display = 'none';
                alergiaOtrosInput.value = '';
            }
        });
    });

    function limpiarFormulario() {
        const formulario = document.getElementById("form-proveedor");

        // Limpiar campos manualmente
        const elementos = formulario.querySelectorAll("input, textarea, select");
        elementos.forEach(elemento => {
            if (elemento.type === "checkbox" || elemento.type === "radio") {
                elemento.checked = false;
            } else {
                elemento.value = "";
            }
        });

        // Quitar clases de error
        const inputsInvalidos = formulario.querySelectorAll('.form-control.is-invalid');
        inputsInvalidos.forEach(input => {
            input.classList.remove('is-invalid');
        });

        // Borrar los mensajes de error
        const mensajesError = formulario.querySelectorAll('.invalid-feedback');
        mensajesError.forEach(msg => {
            msg.textContent = '';
        });

        function limpiarErrores() {
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        }

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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



