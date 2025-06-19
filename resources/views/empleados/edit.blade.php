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
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" class="form-control">
                    <div class="invalid-feedback" id="error-nombre"></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Apellido:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $empleado->apellido) }}" class="form-control">
                <div class="invalid-feedback" id="error-apellido"></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Identidad:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                    <input type="text" id="identidad" name="identidad" value="{{ old('identidad', $empleado->identidad) }}" class="form-control" oninput="formatearIdentidad(this)">
                <div class="invalid-feedback" id="error-identidad"></div>
                    @error('identidad') {{ $message }} @enderror
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Dirección:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}" class="form-control" oninput="validarTexto(this,25)">
                    <div class="invalid-feedback" id="error-direccion"></div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Correo electrónico:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" id="email" name="email" value="{{ old('email', $empleado->email) }}" class="form-control" oninput="validarCorreo(this, 50)">
                    <div class="invalid-feedback" id="error-email"></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Teléfono:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $empleado->telefono) }}" class="form-control" maxlength="8" oninput="formatearTelefono(this)">
                    <div class="invalid-feedback" id="error-telefono"></div>
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
                <div class="invalid-feedback" id="error-tipodesangre"></div>
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
                            {{ in_array($alergia, $alergiasEmpleado) ? 'checked' : '' }}
                        >

                        <label class="form-check-label">{{ $alergia }}</label>
                    </div>
                @endforeach
                {{-- ✅ Mostrar mensaje de error una sola vez --}}
                @error('alergias')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

                <!-- Campo para especificar alergia a alimentos -->
                <input type="text" id="alergiaAlimentos" name="alergiaAlimentos" maxlength="150"
                       value="{{ old('alergiaAlimentos') }}" class="form-control mt-2 solo-letras" placeholder="Especifique alergia a alimentos"
                       style="display:none;">
                <div class="invalid-feedback">
                    @error('alergiaAlimentos') {{ $message }} @enderror
                </div>
                <!-- Campo para especificar alergia a medicamentos -->
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
                       style="{{ in_array('Otros', $alergiasEmpleado) ? '' : 'display:none;' }}">

                <div class="invalid-feedback" id="error-alergia"></div>
            </div>

            <h3 class="text-center mt-4 mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>Contacto de emergencia
            </h3>

            <div class="col-md-4">
                <label class="form-label fw-bold">Nombre completo:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                    <input type="text" id="contactoEmergencia" name="contactoEmergencia" value="{{ old('contactoEmergencia', $empleado->contactoEmergencia) }}" class="form-control">
                    <div class="invalid-feedback" id="error-contacto"></div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Teléfono:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefonodeemergencia" name="telefonodeemergencia" value="{{ old('telefonodeemergencia', $empleado->telefonodeemergencia) }}" class="form-control" maxlength="8" oninput="formatearTelefono(this)"
                    >
                </div>
                <div class="invalid-feedback" id="error-telefonoEmergencia"></div>
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

            // Si se selecciona "Otros"
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

            // Si se selecciona "Ninguno"
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

            // Si no se seleccionó "Otros" ni "Ninguno"
            else {
                otrosCheckbox.disabled = false;
                ningunoCheckbox.disabled = false;
                checkboxes.forEach(chk => {
                    chk.disabled = false;
                });

                // Mostrar/ocultar campos según lo que quede seleccionado
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
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            });
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const formulario = document.getElementById('empleadoForm');

        formulario.addEventListener('reset', function () {
            setTimeout(() => {
                // Limpiar clases de error
                const campos = formulario.querySelectorAll('.form-control, .form-select');
                campos.forEach(campo => {
                    campo.classList.remove('is-invalid');
                });

                // Limpiar mensajes de error
                const mensajes = formulario.querySelectorAll('.invalid-feedback');
                mensajes.forEach(m => {
                    m.textContent = '';
                });

                // Limpiar checkboxes seleccionados de alergias
                const checks = formulario.querySelectorAll('input[name="alergias[]"]');
                checks.forEach(check => {
                    check.checked = false;
                    check.classList.remove('is-invalid');
                });

                // Ocultar campo "Otros" si estaba visible
                const campoOtros = document.getElementById('alergiaOtros');
                if (campoOtros) {
                    campoOtros.value = '';
                    campoOtros.style.display = 'none';
                    campoOtros.classList.remove('is-invalid');
                }

                // Ocultar mensajes de error personalizados
                const errorAlergias = document.getElementById('error-alergias');
                if (errorAlergias) {
                    errorAlergias.textContent = '';
                }

                // También podrías ocultar alimentos/medicamentos si tienes esos campos
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
    document.addEventListener('DOMContentLoaded', () => {
        const alergiasOriginales = @json($empleado->alergias);

        // Restaurar valores al hacer reset
        document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
            e.preventDefault();

            document.querySelectorAll('[data-original]').forEach(input => {
                input.value = input.getAttribute('data-original');
            });

            const tipo = document.getElementById('tipodesangre');
            const original = tipo.getAttribute('data-original');
            if (original) tipo.value = original;

            document.querySelectorAll('.alergia-checkbox').forEach(chk => {
                chk.checked = alergiasOriginales.includes(chk.value);
            });

            const otros = document.getElementById('alergiaOtros');
            if (alergiasOriginales.includes('Otros')) {
                otros.style.display = 'block';
                otros.value = @json($empleado->alergiaOtros);
            } else {
                otros.style.display = 'none';
                otros.value = '';
            }

            limpiarErrores();
        });

        // Mostrar/Ocultar campo "Otros"
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

        setTimeout(toggleAlergiaOtros, 0);
        document.querySelectorAll('.alergia-checkbox').forEach(chk => {
            chk.addEventListener('change', toggleAlergiaOtros);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

