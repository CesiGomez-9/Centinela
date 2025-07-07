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
        <div class="d-flex justify-content-center mb-4">
            <h3 class="mb-0 text-center" style="color: #09457f;">
                <i class="bi bi-person-badge-fill me-2"></i>Editar datos del empleado
            </h3>
        </div>


    <form  id="empleadoForm" action="{{ route('empleados.update', $empleado->id) }}" method="POST" onsubmit="return validarFormulario()" novalidate>
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-4">
                <label class="form-label fw-bold">Nombre:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="nombre" name="nombre"
                           value="{{ old('nombre', $empleado->nombre) }}"
                           class="form-control @error('nombre') is-invalid @enderror"
                           data-original="{{ old('nombre', $empleado->nombre) }}"
                           oninput="validarTexto(this,50)" />

                    <div class="invalid-feedback">@error('nombre') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Apellido:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="apellido" name="apellido"
                           value="{{ old('apellido', $empleado->apellido) }}"
                           class="form-control @error('apellido') is-invalid @enderror"
                           data-original="{{ old('apellido', $empleado->apellido) }}"
                           oninput="validarTexto(this,50)" />
                    <div class="invalid-feedback">@error('apellido') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Identidad:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                    <input type="text" id="identidad" name="identidad"
                           value="{{ old('identidad', $empleado->identidad) }}"
                           class="form-control @error('identidad') is-invalid @enderror"
                           oninput="formatearIdentidad(this)"
                           data-original="{{ old('identidad', $empleado->identidad) }}" />
                    <div class="invalid-feedback">@error('identidad') {{ $message }} @enderror</div>
                    <div id="errorIdentidad" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Teléfono:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefono" name="telefono"
                           value="{{ old('telefono', $empleado->telefono) }}"
                           class="form-control @error('telefono') is-invalid @enderror"
                           maxlength="8" oninput="formatearTelefono(this)"
                           data-original="{{ old('telefono', $empleado->telefono) }}" />
                    <div class="invalid-feedback">@error('telefono') {{ $message }} @enderror</div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Correo electrónico:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" id="email" name="email" maxlength="50"
                           value="{{ old('email', $empleado->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           data-original="{{ old('email', $empleado->email) }}"
                           oninput="validarCorreo(this, 50)" />
                    <div class="invalid-feedback">@error('email') {{ $message }} @enderror</div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Tipo de sangre:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-droplet-fill"></i></span>
                    <select id="tipodesangre" name="tipodesangre"
                            class="form-select @error('tipodesangre') is-invalid @enderror"
                            data-original="{{ old('tipodesangre', $empleado->tipodesangre) }}">
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
                    Seleccione las alergias:
                </label>
                @php
                    $alergiasRaw = old('alergias', $empleado->alergias ?? []);

                    $alergiasEmpleado = [];
                    $alergiaOtrosTexto = old('alergiaOtros', '');
                    $alergiaAlimentosTexto = old('alergiaAlimentos', '');
                    $alergiaMedicamentosTexto = old('alergiaMedicamentos', '');

                    foreach ($alergiasRaw as $a) {
                        if (str_starts_with($a, 'Otros:')) {
                            $alergiasEmpleado[] = 'Otros';
                            if ($alergiaOtrosTexto === '') {
                                $alergiaOtrosTexto = trim(substr($a, strlen('Otros:')));
                            }
                        } elseif (str_starts_with($a, 'Alimentos:')) {
                            $alergiasEmpleado[] = 'Alimentos';
                            if ($alergiaAlimentosTexto === '') {
                                $alergiaAlimentosTexto = trim(substr($a, strlen('Alimentos:')));
                            }
                        } elseif (str_starts_with($a, 'Medicamentos:')) {
                            $alergiasEmpleado[] = 'Medicamentos';
                            if ($alergiaMedicamentosTexto === '') {
                                $alergiaMedicamentosTexto = trim(substr($a, strlen('Medicamentos:')));
                            }
                        } else {
                            $alergiasEmpleado[] = $a;
                        }
                    }
                @endphp


                <div id="alergias-container" data-original='@json($alergiasEmpleado)'>
                    <div class="row">
                        <div class="col-md-4 d-flex flex-column gap-2">
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" value="Polvo" name="alergias[]"
                                       {{ in_array('Polvo', $alergiasEmpleado) ? 'checked' : '' }} id="alergiaPolvo">
                                <label class="form-check-label ms-2" for="alergiaPolvo">Polvo</label>
                            </div>
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" value="Polen" name="alergias[]"
                                       {{ in_array('Polen', $alergiasEmpleado) ? 'checked' : '' }} id="alergiaPolen">
                                <label class="form-check-label ms-2" for="alergiaPolen">Polen</label>
                            </div>
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" value="Ninguno" name="alergias[]"
                                       {{ in_array('Ninguno', $alergiasEmpleado) ? 'checked' : '' }} id="alergiaNinguno">
                                <label class="form-check-label ms-2" for="alergiaNinguno">Ninguno</label>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check me-2">
                                    <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" value="Alimentos" name="alergias[]"
                                           {{ in_array('Alimentos', $alergiasEmpleado) ? 'checked' : '' }} id="alergiaAlimentosChk">
                                    <label class="form-check-label" for="alergiaAlimentosChk">Alimentos</label>
                                </div>
                                <input type="text" id="alergiaAlimentos" name="alergiaAlimentos" maxlength="150"
                                       value="{{ old('alergiaAlimentos', $empleado->alergiaAlimentos) }}"
                                       class="form-control solo-letras flex-grow-1 @error('alergiaAlimentos') is-invalid @enderror"
                                       placeholder="Especifique a qué alimentos es alérgico"
                                       data-original="{{ old('alergiaAlimentos', $empleado->alergiaAlimentos) }}"
                                       style="{{ (is_array($alergiasEmpleado) && in_array('Alimentos', $alergiasEmpleado)) ? '' : 'display:none;  min-width: 400px;' }}" />
                                <div class="invalid-feedback">
                                    @error('alergiaAlimentos') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check me-2">
                                    <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" value="Medicamentos" name="alergias[]"
                                           {{ in_array('Medicamentos', $alergiasEmpleado) ? 'checked' : '' }} id="alergiaMedicamentosChk">
                                    <label class="form-check-label" for="alergiaMedicamentosChk">Medicamentos</label>
                                </div>
                                <input type="text" id="alergiaMedicamentos" name="alergiaMedicamentos" maxlength="150"
                                       value="{{ old('alergiaMedicamentos', $empleado->alergiaMedicamentos) }}"
                                       class="form-control solo-letras flex-grow-1 @error('alergiaMedicamentos') is-invalid @enderror"
                                       placeholder="Especifique a qué medicamentos es alérgico"
                                       data-original="{{ old('alergiaMedicamentos', $empleado->alergiaMedicamentos) }}"
                                       style="{{ (is_array($alergiasEmpleado) && in_array('Medicamentos', $alergiasEmpleado)) ? '' : 'display:none;  min-width: 400px;' }}" />
                                <div class="invalid-feedback">
                                    @error('alergiaMedicamentos') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="form-check me-2">
                                    <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" value="Otros" name="alergias[]"
                                           {{ in_array('Otros', $alergiasEmpleado) ? 'checked' : '' }} id="alergiaOtrosChk">
                                    <label class="form-check-label" for="alergiaOtrosChk">Otros</label>
                                </div>
                                <input type="text" id="alergiaOtros" name="alergiaOtros" maxlength="150"
                                       value="{{ old('alergiaOtros', $empleado->alergiaOtros) }}"
                                       class="form-control solo-letras flex-grow-1 @error('alergiaOtros') is-invalid @enderror"
                                       placeholder="Especifique otras alergias"
                                       data-original="{{ old('alergiaOtros', $empleado->alergiaOtros) }}"
                                       style="{{ (is_array($alergiasEmpleado) && in_array('Otros', $alergiasEmpleado)) ? '' : 'display:none;  min-width: 400px;' }}" />
                                <div class="invalid-feedback">
                                    @error('alergiaOtros') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @error('alergias')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Departamento</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <select id="departamento" name="departamento"
                            class="form-select @error('departamento') is-invalid @enderror">
                        <option value="">Seleccione...</option>
                        @foreach(['Atlántida', 'Choluteca ', 'Colón', 'Comayagua ', 'Copán',
                            'Cortés ', 'El Paraíso', 'Francisco Morazán', 'Gracias a Dios',
                            'Intibucá ', 'Islas de la Bahía', 'La Paz', 'Lempira',
                            'Ocotepeque', 'Olancho ', 'Santa Bárbara', 'Valle ', 'Yoro'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('departamento', $empleado->departamento) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">@error('departamento') {{ $message }} @enderror</div>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Dirección:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <textarea id="direccion" name="direccion" maxlength="250"
                              class="form-control @error('direccion') is-invalid @enderror"
                              oninput="validarTexto(this,250)"
                              rows="1"
                              data-original="{{ old('direccion', $empleado->direccion) }}"
                              style="resize: vertical;">{{ old('direccion', $empleado->direccion) }}</textarea>
                    <div class="invalid-feedback">@error('direccion') {{ $message }} @enderror</div>
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
                           value="{{ old('contactodeemergencia', $empleado->contactodeemergencia) }}"
                           class="form-control @error('contactodeemergencia') is-invalid @enderror"
                           data-original="{{ old('contactodeemergencia', $empleado->contactodeemergencia) }}"
                           oninput="validarTexto(this,100)" />
                    <div class="invalid-feedback">@error('contactodeemergencia') {{ $message }} @enderror</div>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Teléfono:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" id="telefonodeemergencia" name="telefonodeemergencia"
                           value="{{ old('telefonodeemergencia', $empleado->telefonodeemergencia) }}"
                           class="form-control @error('telefonodeemergencia') is-invalid @enderror"
                           maxlength="8" oninput="formatearTelefono(this)"
                           data-original="{{ old('telefonodeemergencia', $empleado->telefonodeemergencia) }}" />
                </div>
                <div class="invalid-feedback">@error('telefonodeemergencia') {{ $message }} @enderror</div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('empleados.index', $empleado->id) }}" class="btn btn-danger">
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
        const form = document.getElementById('empleadoForm');
        const resetBtn = form.querySelector('button[type="reset"]');
        form.querySelectorAll('input, select, textarea').forEach(el => {
            el.setAttribute('data-original', el.value);
        });
        ['alergiaOtros', 'alergiaAlimentos', 'alergiaMedicamentos'].forEach(id => {
            const campo = document.getElementById(id);
            if (campo) {
                campo.setAttribute('data-original', campo.value);
            }
        });
        const valoresOriginales = {
            nombre: @json($empleado->nombre),
            apellido: @json($empleado->apellido),
            identidad: @json($empleado->identidad),
            telefono: @json($empleado->telefono),
            email: @json($empleado->email),
            tipodesangre: @json($empleado->tipodesangre),
            alergias: @json($empleado->alergias ?? []),
            alergiaAlimentos: @json($empleado->alergiaAlimentos),
            alergiaMedicamentos: @json($empleado->alergiaMedicamentos),
            alergiaOtros: @json($empleado->alergiaOtros),
            departamento: @json($empleado->departamento),
            direccion: @json($empleado->direccion),
            contactodeemergencia: @json($empleado->contactodeemergencia),
            telefonodeemergencia: @json($empleado->telefonodeemergencia)
        };

        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Quitar estilos de error
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(div => div.textContent = '');

            // Restaurar inputs con valores originales "puros"
            form.querySelector('#nombre').value = valoresOriginales.nombre || '';
            form.querySelector('#apellido').value = valoresOriginales.apellido || '';
            form.querySelector('#identidad').value = valoresOriginales.identidad || '';
            form.querySelector('#telefono').value = valoresOriginales.telefono || '';
            form.querySelector('#email').value = valoresOriginales.email || '';
            form.querySelector('#tipodesangre').value = valoresOriginales.tipodesangre || '';
            form.querySelector('#departamento').value = valoresOriginales.departamento || '';
            form.querySelector('#direccion').value = valoresOriginales.direccion || '';
            form.querySelector('#contactodeemergencia').value = valoresOriginales.contactodeemergencia || '';
            form.querySelector('#telefonodeemergencia').value = valoresOriginales.telefonodeemergencia || '';

            // Restaurar checkboxes de alergias
            const checkboxes = form.querySelectorAll('input.alergia-checkbox[type="checkbox"]');
            checkboxes.forEach(chk => {
                chk.checked = valoresOriginales.alergias.includes(chk.value);
            });

            // Restaurar inputs adicionales de alergias
            form.querySelector('#alergiaAlimentos').value = valoresOriginales.alergiaAlimentos || '';
            form.querySelector('#alergiaMedicamentos').value = valoresOriginales.alergiaMedicamentos || '';
            form.querySelector('#alergiaOtros').value = valoresOriginales.alergiaOtros || '';

            // Mostrar u ocultar campos extra de alergias según correspondan
            toggleCamposAlergiasConValores(valoresOriginales.alergias);
        });

        function toggleCamposAlergiasConValores(alergias) {
            const campos = {
                'Otros': document.getElementById('alergiaOtros'),
                'Alimentos': document.getElementById('alergiaAlimentos'),
                'Medicamentos': document.getElementById('alergiaMedicamentos')
            };

            for (const key in campos) {
                if (alergias.includes(key)) {
                    campos[key].style.display = '';
                    campos[key].value = campos[key].getAttribute('data-original') || '';
                } else {
                    campos[key].style.display = 'none';
                    campos[key].value = '';
                }
            }
        }
    });

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

    function toggleCamposAlergias(alergias) {
        const campos = {
            'Otros': document.getElementById('alergiaOtros'),
            'Alimentos': document.getElementById('alergiaAlimentos'),
            'Medicamentos': document.getElementById('alergiaMedicamentos')
        };

        for (const key in campos) {
            if (alergias.includes(key)) {
                campos[key].style.display = '';
            } else {
                campos[key].style.display = 'none';
                campos[key].value = '';
            }
        }
    }


    function validarTexto(input, max) {
        input.value = input.value
            .replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,;#\-]/g, '')
            .replace(/\s+/g,' ')
            .slice(0, max);
    }

    const municipiosPorDepartamento = {
        "01": [ "01", "02", "03", "04", "05", "06", "07", "08" ], // Atlántida
        "02": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16" ], // Choluteca
        "03": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10" ], // Colón
        "04": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20","21" ], // Comayagua
        "05": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15", "16", "17", "18", "19", "20","21", "22", "23" ], // Copán
        "06": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ], // Cortés
        "07": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" ], // El Paraíso
        "08": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18","19","20","21", "22", "23", "24", "25", "26", "27", "28" ], // Francisco Morazán
        "09": [ "01", "02", "03", "04", "05", "06" ], // Gracias a Dios (6 municipios)
        "10": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17" ], // Intibucá
        "11": [ "01", "02", "03", "04" ], // Islas de la Bahía (4 municipios)
        "12": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19" ], // La Paz
        "13": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26","27","28" ], // Lempira
        "14": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15", "16" ], // Ocotepeque
        "15": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"], // Olancho
        "16": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19","20","21", "22", "23", "24", "25", "26", "27", "28" ], // Santa Bárbara
        "17": [ "01", "02", "03", "04", "05", "06", "07", "08", "09" ], // Valle
        "18": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11"] // Yoro
    };


    function formatearIdentidad(i) {
        let v = i.value.replace(/[^0-9]/g, '');
        if (v.length >= 4) {
            const pref4 = v.slice(0,4), pref2 = v.slice(0,2);
            if (!codigosDep.includes(pref2)) {
                v = '';
            } else {
                const departamento = pref2;
                const municipio = v.slice(2,4);
                if (!municipiosPorDepartamento[departamento] || !municipiosPorDepartamento[departamento].includes(municipio)) {
                    v = '';
                }
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
            if (isNaN(anioNum) || anioNum < 1940 || anioNum > 2007) {
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

