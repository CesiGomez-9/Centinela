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
            <img src="{{ asset('centinela.jpg') }}" style="height:80px; margin-right: 10px;" alt="Logo Grupo Centinela">
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
            <i class="bi bi-person-badge-fill me-2"></i>Editar datos del empleado
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
                <label class="form-label fw-bold">Nombre:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="nombre" name="nombre"
                           value="{{ old('nombre', $empleado->nombre) }}"
                           class="form-control" data-original="{{ $empleado->nombre }}
                           @error('nombre') is-invalid @enderror"
                           oninput="validarTexto(this,50)" />">
                    <div class="invalid-feedback">@error('nombre') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Apellido:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="apellido" name="apellido"
                           value="{{ old('apellido', $empleado->apellido) }}"
                           class="form-control" data-original="{{ $empleado->apellido }}
                           @error('apellido') is-invalid @enderror"
                           oninput="validarTexto(this,50)" />">
                    <div class="invalid-feedback">@error('apellido') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Identidad:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                    <input type="text" id="identidad" name="identidad" value="{{ old('identidad', $empleado->identidad) }}" class="form-control" oninput="formatearIdentidad(this)" data-original="{{ $empleado->identidad }}">
                    <div class="invalid-feedback">@error('identidad') {{ $message }} @enderror</div>
                    <div id="errorIdentidad" class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Dirección:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}" class="form-control" oninput="validarTexto(this,25)" data-original="{{ $empleado->direccion }}">
                    <div class="invalid-feedback">@error('direccion') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Correo electrónico:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" id="email" name="email" value="{{ old('email', $empleado->email) }}" class="form-control" oninput="validarCorreo(this, 50)" data-original="{{ $empleado->email }}">
                    <div class="invalid-feedback">@error('email') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Teléfono:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $empleado->telefono) }}" class="form-control" maxlength="8" oninput="formatearTelefono(this)" data-original="{{ $empleado->telefono }}">
                    <div class="invalid-feedback">@error('telefono') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Tipo de sangre:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-droplet-fill"></i></span>
                    <select id="tipodesangre" name="tipodesangre" class="form-select" data-original="{{ $empleado->tipodesangre }}">
                        <option value="">Seleccione...</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipodesangre', $empleado->tipodesangre) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="invalid-feedback">@error('tipodesangre') {{ $message }} @enderror</div>
            </div>

            <div class="col-md-10">
                <label class="form-label fw-bold">
                    <i class="bi bi-exclamation-diamond-fill me-2"></i>
                    Alergias (seleccione):
                </label>
                @php
                    $tiposAlergia = ['Polvo', 'Polen', 'Medicamentos', 'Alimentos', 'Ninguno', 'Otros'];
                    $alergiasEmpleado = old('alergias', $empleado->alergias ?? []);
                @endphp
                @foreach($tiposAlergia as $alergia)
                    <div class="form-check form-check-inline">
                        <input
                                class="form-check-input alergia-checkbox"
                                type="checkbox"
                                value="{{ $alergia }}"
                                name="alergias[]"
                                {{ (is_array($alergiasEmpleado) && in_array($alergia, $alergiasEmpleado)) ? 'checked' : '' }}>

                        <label class="form-check-label">{{ $alergia }}</label>
                    </div>
                @endforeach
                @error('alergias')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <input type="text" id="alergiaAlimentos" name="alergiaAlimentos" maxlength="150"
                       value="{{ old('alergiaAlimentos') }}" class="form-control mt-2 solo-letras" placeholder="Especifique alergia a alimentos"
                       style="display:none;">
                <div class="invalid-feedback">
                    @error('alergiaAlimentos') {{ $message }} @enderror
                </div>

                <input type="text" id="alergiaMedicamentos" name="alergiaMedicamentos" maxlength="150"
                       value="{{ old('alergiaMedicamentos') }}" class="form-control mt-2 solo-letras" placeholder="Especifique alergia a medicamentos"
                       style="display:none;">
                <div class="invalid-feedback">
                    @error('alergiaMedicamentos') {{ $message }} @enderror
                </div>
                <input type="text" id="alergiaOtros" name="alergiaOtros"
                       value="{{ $empleado->alergiaOtros }}"
                       class="form-control mt-2 solo-letras"
                       placeholder="Especifique si es Otros"
                       style="{{ (is_array($alergiasEmpleado) && in_array('Otros', $alergiasEmpleado)) ? '' : 'display:none;' }}">

                <div class="invalid-feedback">
                    @error('alergiaOtros') {{ $message }} @enderror
                </div>
            </div>

            <h3 class="text-center mt-4 mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>Contacto de emergencia
            </h3>

            <div class="col-md-4">
                <label class="form-label fw-bold">Nombre completo:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                    <input type="text" id="contactodeemergencia" name="contactodeemergencia"
                           value="{{ old('contactodeemergencia', $empleado->contactodeemergencia) }}
                           " class="form-control" data-original="{{ $empleado->contactodeemergencia }}
                           @error('contactodeemergencia') is-invalid @enderror"
                           oninput="validarTexto(this,100)" />">
                    <div class="invalid-feedback">@error('contactodeemergencia') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Teléfono:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefonodeemergencia" name="telefonodeemergencia" value="{{ old('telefonodeemergencia', $empleado->telefonodeemergencia) }}" class="form-control" maxlength="8" oninput="formatearTelefono(this)" data-original="{{ $empleado->telefonodeemergencia }}">
                </div>
                <div class="invalid-feedback">@error('telefonodeemergencia') {{ $message }} @enderror</div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-danger">
                    <i class="bi bi-x-circle me-2"></i> Cancelar
                </a>

                <button type="reset" class="btn btn-warning me-2">
                    <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save-fill me-2"></i> Guardar
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const codigosDep = Array.from({length:18}, (_,i) => String(i+1).padStart(2,'0'));

    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('input[name="alergias[]"]');
        const otrosCheckbox = document.querySelector('input[name="alergias[]"][value="Otros"]');
        const ningunoCheckbox = document.querySelector('input[name="alergias[]"][value="Ninguno"]');
        const alimentosCheckbox = document.querySelector('input[name="alergias[]"][value="Alimentos"]');
        const medicamentosCheckbox = document.querySelector('input[name="alergias[]"][value="Medicamentos"]');

        const campoAlimentos = document.getElementById('alergiaAlimentos');
        const campoMedicamentos = document.getElementById('alergiaMedicamentos');
        const campoOtros = document.getElementById('alergiaOtros');

        function actualizarCampos() {
            const otrosChecked = otrosCheckbox.checked;
            const ningunoChecked = ningunoCheckbox.checked;
            const alimentosChecked = alimentosCheckbox.checked;
            const medicamentosChecked = medicamentosCheckbox.checked;

            if (otrosChecked) {
                ningunoCheckbox.checked = false;
                ningunoCheckbox.disabled = true;
                checkboxes.forEach(chk => {
                    if (chk !== otrosCheckbox && chk !== ningunoCheckbox) {
                        chk.checked = false;
                        chk.disabled = true;
                    }
                });
                campoOtros.style.display = 'block';
                campoAlimentos.style.display = 'none';
                campoMedicamentos.style.display = 'none';
                campoAlimentos.value = '';
                campoMedicamentos.value = '';
            }

            else if (ningunoChecked) {
                otrosCheckbox.checked = false;
                otrosCheckbox.disabled = true;
                checkboxes.forEach(chk => {
                    if (chk !== ningunoCheckbox && chk !== otrosCheckbox) {
                        chk.checked = false;
                        chk.disabled = true;
                    }
                });
                campoOtros.style.display = 'none';
                campoAlimentos.style.display = 'none';
                campoMedicamentos.style.display = 'none';
                campoOtros.value = '';
                campoAlimentos.value = '';
                campoMedicamentos.value = '';
            }

            else {
                otrosCheckbox.disabled = false;
                ningunoCheckbox.disabled = false;
                checkboxes.forEach(chk => {
                    chk.disabled = false;
                });

                campoOtros.style.display = otrosCheckbox.checked ? 'block' : 'none';
                campoAlimentos.style.display = alimentosCheckbox.checked ? 'block' : 'none';
                campoMedicamentos.style.display = medicamentosCheckbox.checked ? 'block' : 'none';
            }
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', actualizarCampos);
        });

        actualizarCampos();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const campos = document.querySelectorAll('.solo-letras');

        campos.forEach(input => {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
            });
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const formulario = document.getElementById('empleadoForm');

        formulario.addEventListener('reset', function () {
            setTimeout(() => {

                const campos = formulario.querySelectorAll('.form-control, .form-select');
                campos.forEach(campo => {
                    campo.classList.remove('is-invalid');
                });

                const mensajes = formulario.querySelectorAll('.invalid-feedback');
                mensajes.forEach(m => {
                    m.textContent = '';
                });

                const checks = formulario.querySelectorAll('input[name="alergias[]"]');
                checks.forEach(check => {
                    check.checked = false;
                    check.classList.remove('is-invalid');
                });

                const campoOtros = document.getElementById('alergiaOtros');
                if (campoOtros) {
                    campoOtros.value = '';
                    campoOtros.style.display = 'none';
                    campoOtros.classList.remove('is-invalid');
                }

                const errorAlergias = document.getElementById('error-alergias');
                if (errorAlergias) {
                    errorAlergias.textContent = '';
                }

                const campoAlimentos = document.getElementById('alergiaAlimentos');
                if (campoAlimentos) {
                    campoAlimentos.value = '';
                    campoAlimentos.style.display = 'none';
                    campoAlimentos.classList.remove('is-invalid');
                }

                const campoMedicamentos = document.getElementById('alergiaMedicamentos');
                if (campoMedicamentos) {
                    campoMedicamentos.value = '';
                    campoMedicamentos.style.display = 'none';
                    campoMedicamentos.classList.remove('is-invalid');
                }

            }, 10);
        });
    });



    function validarTexto(input, max) {
        input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '').replace(/\s+/g,' ').slice(0, max);
    }

    function formatearIdentidad(i) {
        let v = i.value.replace(/[^0-9]/g, '');
        if (v.length >= 4) {
            const pref4 = v.slice(0,4), pref2 = v.slice(0,2);
            if (!codigosDep.includes(pref4) && !codigosDep.includes(pref2)) {
                v = '';
            }
        } else if (v.length >= 2) {
            if (!codigosDep.includes(v.slice(0,2))) v = '';
        }
        v = v.slice(0,13);
        if (v.length > 8) i.value = v.slice(0,4) + '-' + v.slice(4,8) + '-' + v.slice(8);
        else if (v.length > 4) i.value = v.slice(0,4) + '-' + v.slice(4);
        else i.value = v;

        if (v.length >= 8) {
            let anio = v.slice(4, 8);
            let anioNum = parseInt(anio, 10);

            if (isNaN(anioNum) || anioNum <= 1940) {
                anioNum = 1940;
            } else if (anioNum >= 2007) {
                anioNum = 2007;
            }

            const anioStr = anioNum.toString().padStart(4, '0');
            v = v.slice(0, 4) + anioStr + v.slice(8);

            if (anioNum <= 1939 || anioNum >= 2008) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'El año debe ser igual o mayor a 1940 y menor o igual a 2007.';
            } else {
                i.classList.remove('is-invalid');
                document.getElementById('errorIdentidad').textContent = '';
            }
        } else {
            i.classList.remove('is-invalid');
            document.getElementById('errorIdentidad').textContent = '';
        }

        v = v.slice(0, 13);
        if (v.length > 8) {
            i.value = v.slice(0, 4) + '-' + v.slice(4, 8) + '-' + v.slice(8);
        } else if (v.length > 4) {
            i.value = v.slice(0, 4) + '-' + v.slice(4);
        } else {
            i.value = v;
        }
    }

    function configurarValidacionTelefono(id) {
        const input = document.getElementById(id);

        input.addEventListener('keydown', function(e) {
            const teclasPermitidas = [
                'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', 'Home', 'End'
            ];
            if (teclasPermitidas.includes(e.key)) return;

            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
                return;
            }
            if (this.selectionStart === 0 && !['2', '3', '8', '9'].includes(e.key)) {
                e.preventDefault();
            }
        });

        input.addEventListener('input', function() {
            let valor = this.value.replace(/[^0-9]/g, '');
            if (valor.length > 0 && !['2', '3', '8', '9'].includes(valor[0])) {
                valor = valor.slice(1);
            }

            if (valor.length > 8) {
                valor = valor.slice(0, 8);
            }

            if (/^(\d)\1{7}$/.test(valor)) {
                valor = '';
            }

            this.value = valor;
        });
    }

    configurarValidacionTelefono('telefono');
    configurarValidacionTelefono('telefonodeemergencia');

    document.addEventListener('DOMContentLoaded', function () {
        permitirSoloTelefonosValidos(document.getElementById('telefono'));
        permitirSoloTelefonosValidos(document.getElementById('telefonodeemergencia'));
    });


    document.querySelectorAll('.alergia-checkbox').forEach(chk => {
        chk.addEventListener('change', () => {
            document.getElementById('alergiaOtros').style.display =
                document.querySelector('.alergia-checkbox[value="Otros"]').checked ? 'block' : 'none';
        });
    });





    document.addEventListener('DOMContentLoaded', function () {
        const checkboxOtros = document.querySelector('input[name="alergias[]"][value="Otros"]');
        const campoOtros = document.getElementById('alergiaOtros');
        const formulario = document.getElementById('empleadoForm');

        checkboxOtros.addEventListener('change', function () {
            if (this.checked) {
                campoOtros.style.display = 'block';
            } else {
                campoOtros.style.display = 'none';
                campoOtros.classList.remove('is-invalid');
            }
        });

        formulario.addEventListener('submit', function (e) {
            let errores = [];

            if (checkboxOtros.checked && campoOtros.value.trim() === '') {
                campoOtros.classList.add('is-invalid');
                errores.push('Debe especificar la alergia Otros');
            } else {
                campoOtros.classList.remove('is-invalid');
            }

            if (errores.length > 0) {
                e.preventDefault();
            }
        });

        campoOtros.addEventListener('input', function () {
            if (campoOtros.value.trim() !== '') {
                campoOtros.classList.remove('is-invalid');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxOtros = document.querySelector('input[value="Otros"]');
        const campoOtros = document.getElementById('alergiaOtros');

        checkboxOtros.addEventListener('change', function () {
            if (this.checked) {
                campoOtros.style.display = 'block';
            } else {
                campoOtros.style.display = 'none';
                campoOtros.value = '';
            }
        });
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

