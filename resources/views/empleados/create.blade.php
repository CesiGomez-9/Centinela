<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8"/>
    <title>Registrar empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <style>

    </style>
</head>
<body style="background-color: #e6f0ff;">

<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding:1.2rem; font-family:'Courier New', monospace;">
    <div class="container" style="max-width:1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('centinela.jpg) }}" style="height:80px; margin-right:10px;"/>
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
<div class="container mt-5" style="max-width:900px;">
    <div class="card shadow p-4 bg-white position-relative">
        <i class="bi bi-person-badge position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>

        <h3 class="text-center mb-4" style="color:#09457f;">
            <i class="bi bi-people-fill me-2"></i>
            @isset($empleado) Editar empleado @else Registrar un nuevo empleado @endisset
        </h3>

        @if(session('guardado'))
            <div class="alert alert-success">¡Datos guardados correctamente!</div>
        @endif

        <form method="POST" action="{{ route('empleados.store') }}" id="empleadoForm" novalidate>
            @csrf
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-bold">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" id="nombre" name="nombre" maxlength="50"
                               value="{{ old('nombre') }}"
                               class="form-control @error('nombre') is-invalid @enderror"
                               oninput="validarTexto(this,50)" />
                        <div class="invalid-feedback">@error('nombre') {{ $message }} @enderror</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Apellido</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" id="apellido" name="apellido" maxlength="50"
                               value="{{ old('apellido') }}"
                               class="form-control @error('apellido') is-invalid @enderror"
                               oninput="validarTexto(this,50)" />
                        <div class="invalid-feedback">@error('apellido') {{ $message }} @enderror</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Identidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                        <input type="text" id="identidad" name="identidad" maxlength="15"
                               value="{{ old('identidad') }}"
                               class="form-control @error('identidad') is-invalid @enderror"
                               oninput="formatearIdentidad(this)" />
                        <div class="invalid-feedback">@error('identidad') {{ $message }} @enderror</div>
                        <div id="errorIdentidad" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                        <input type="text" id="telefono" name="telefono" maxlength="8"
                               value="{{ old('telefono') }}"
                               class="form-control @error('telefono') is-invalid @enderror"
                               oninput="formatearTelefono(this)" />
                        <div class="invalid-feedback">@error('telefono') {{ $message }} @enderror</div>
                    </div>
                </div>


                <div class="col-md-4">
                    <label class="form-label fw-bold">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" id="email" name="email" maxlength="50"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" />
                        <div class="invalid-feedback">@error('email') {{ $message }} @enderror</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Tipo de sangre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-droplet-fill"></i></span>
                        <select id="tipodesangre" name="tipodesangre"
                                class="form-select @error('tipodesangre') is-invalid @enderror">
                            <option value="">Seleccione...</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipodesangre')==$tipo?'selected':'' }}>{{ $tipo }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">@error('tipodesangre') {{ $message }} @enderror</div>
                    </div>
                </div>

                <div class="col-md-10">
                    <label class="form-label fw-bold">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i>Seleccione las alergias:
                    </label>
                    @php
                        $tiposAlergia = ['Polvo', 'Polen', 'Medicamentos', 'Alimentos', 'Ninguno', 'Otros'];
                        $oldA = old('alergias', []);
                    @endphp
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" name="alergias[]" value="Polvo" {{ in_array('Polvo', $oldA) ? 'checked' : '' }}>
                                <label class="form-check-label">Polvo</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" name="alergias[]" value="Polen" {{ in_array('Polen', $oldA) ? 'checked' : '' }}>
                                <label class="form-check-label">Polen</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input alergia-checkbox @error('alergias') is-invalid @enderror" type="checkbox" name="alergias[]" value="Ninguno" {{ in_array('Ninguno', $oldA) ? 'checked' : '' }}>
                                <label class="form-check-label">Ninguno</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check mb-2 d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox me-2 @error('alergias') is-invalid @enderror" type="checkbox" name="alergias[]" value="Alimentos" {{ in_array('Alimentos', $oldA) ? 'checked' : '' }}>
                                <label class="form-check-label me-3">Alimentos</label>
                                <input type="text" id="alergiaAlimentos" name="alergiaAlimentos" maxlength="150"
                                       value="{{ old('alergiaAlimentos') }}"
                                       class="form-control solo-letras"
                                       placeholder="Especifique alergia a alimentos"
                                       style="min-width: 350px; {{ in_array('Alimentos', $oldA) ? 'display:block;' : 'display:none;' }}">
                            </div>

                            <div class="form-check mb-2 d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox me-2 @error('alergias') is-invalid @enderror" type="checkbox" name="alergias[]" value="Medicamentos" {{ in_array('Medicamentos', $oldA) ? 'checked' : '' }}>
                                <label class="form-check-label me-3">Medicamentos</label>
                                <input type="text" id="alergiaMedicamentos" name="alergiaMedicamentos" maxlength="150"
                                       value="{{ old('alergiaMedicamentos') }}"
                                       class="form-control solo-letras"
                                       placeholder="Especifique alergia a medicamentos"
                                       style="min-width: 330px; {{ in_array('Medicamentos', $oldA) ? 'display:block;' : 'display:none;' }}">
                            </div>

                            <div class="form-check mb-2 d-flex align-items-center">
                                <input class="form-check-input alergia-checkbox me-2 @error('alergias') is-invalid @enderror" type="checkbox" name="alergias[]" value="Otros" {{ in_array('Otros', $oldA) ? 'checked' : '' }}>
                                <label class="form-check-label me-3">Otros</label>
                                <input type="text" id="alergiaOtros" name="alergiaOtros" maxlength="150"
                                       value="{{ old('alergiaOtros') }}"
                                       class="form-control solo-letras"
                                       placeholder="Especifique alergia"
                                       style="min-width: 350px; {{ in_array('Otros', $oldA) ? 'display:block;' : 'display:none;' }}">
                            </div>
                        </div>
                    </div>

                    @error('alergias')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('alergiaAlimentos')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('alergiaMedicamentos')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('alergiaOtros')
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
                                <option value="{{ $tipo }}" {{ old('departamento')==$tipo?'selected':'' }}>{{ $tipo }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">@error('departamento') {{ $message }} @enderror</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Dirección</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                        <textarea id="direccion" name="direccion" maxlength="250"
                                  class="form-control @error('direccion') is-invalid @enderror"
                                  oninput="validarTexto(this,250)" rows="1"
                                  style="resize: vertical;">{{ old('direccion') }}</textarea>
                        <div class="invalid-feedback">@error('direccion') {{ $message }} @enderror</div>
                    </div>
                </div>


                <h3 class="text-center mb-4 mt-4" style="color:#09457f;">
                    <i class="bi bi-people-fill me-2"></i>Contacto de emergencia
                </h3>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Nombre completo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                        <input type="text" id="contactoEmergencia" name="contactodeemergencia" maxlength="100"
                               value="{{ old('contactodeemergencia') }}"
                               class="form-control @error('contactodeemergencia') is-invalid @enderror"
                               oninput="validarTexto(this,100)" />
                        <div class="invalid-feedback">@error('contactodeemergencia') {{ $message }} @enderror</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                        <input type="text" id="telefonodeemergencia" name="telefonodeemergencia" maxlength="8"
                               value="{{ old('telefonodeemergencia') }}"
                               class="form-control @error('telefonodeemergencia') is-invalid @enderror"
                               oninput="formatearTelefono(this)" />
                        <div class="invalid-feedback">@error('telefonodeemergencia') {{ $message }} @enderror</div>
                    </div>
                </div>

                <div class="text-center mt-5 col-12">
                    <a href="{{ route('empleados.index') }}" class="btn btn-danger me-2">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </a>
                    <button type="reset" class="btn btn-warning me-2"><i class="bi bi-eraser-fill me-2"></i>Limpiar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i>Guardar</button>
                </div>
            </div>
        </form>
    </div>
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

                // Limpiar valores de todos los campos input, select, textarea
                const campos = formulario.querySelectorAll('input, select, textarea');
                campos.forEach(campo => {
                    if (campo.type === 'hidden' && campo.name === '_token') {
                        return; // saltar este campo, no modificar
                    }

                    if (campo.type === 'checkbox' || campo.type === 'radio') {
                        campo.checked = false;
                    } else {
                        campo.value = '';
                    }
                    campo.classList.remove('is-invalid'); // quitar alertas visuales
                });

                // Quitar textos de error
                const mensajes = formulario.querySelectorAll('.invalid-feedback');
                mensajes.forEach(m => {
                    m.textContent = '';
                });

                // Además ocultar campos adicionales de alergias y limpiar valores específicos
                const campoOtros = document.getElementById('alergiaOtros');
                if (campoOtros) {
                    campoOtros.value = '';
                    campoOtros.style.display = 'none';
                    campoOtros.classList.remove('is-invalid');
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

                const errorAlergias = document.getElementById('error-alergias');
                if (errorAlergias) {
                    errorAlergias.textContent = '';
                }

            }, 10);
        });
    });



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
        "09": [ "01", "02", "03", "04", "05", "06" ], // Gracias a Dios
        "10": [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17" ], // Intibucá
        "11": [ "01", "02", "03", "04" ], // Islas de la Bahía
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
                e.preventDefault()
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
