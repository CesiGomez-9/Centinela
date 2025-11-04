@extends('plantilla')
@section('content')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-hospital position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:3rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-clipboard2-pulse me-2"></i>Registrar Incapacidad
            </h3>

            @if(session('success'))
                <div class="alert alert-success text-center">¡Incapacidad registrada correctamente!</div>
            @endif

            <form action="{{ route('incapacidades.store') }}" method="POST" enctype="multipart/form-data" id="incapacidadForm" novalidate>
                @csrf

                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Empleado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   id="empleadoInput"
                                   name="empleado_nombre"
                                   class="form-control @error('empleado_id') is-invalid @enderror"
                                   placeholder="Buscar empleado..."
                                   autocomplete="off"
                                   value="{{ old('empleado_nombre') }}">
                            <input type="hidden" name="empleado_id" id="empleado_id" value="{{ old('empleado_id') }}">
                        </div>
                        <div class="invalid-feedback d-block">@error('empleado_id') {{ $message }} @enderror</div>
                        <div id="empleadoResults" class="list-group" style="max-height:200px; overflow-y:auto;"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Identidad:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                            <input type="text" id="identidad" name="identidad" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cargo:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                            <input type="text" id="cargo" name="cargo" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha inicio:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                   class="form-control @error('fecha_inicio') is-invalid @enderror"
                                   value="{{ old('fecha_inicio') }}" required>
                        </div>
                        <div class="invalid-feedback d-block">@error('fecha_inicio') {{ $message }} @enderror</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha fin:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                            <input type="date" name="fecha_fin" id="fecha_fin"
                                   class="form-control @error('fecha_fin') is-invalid @enderror"
                                   value="{{ old('fecha_fin') }}" required>
                        </div>
                        <div class="invalid-feedback d-block">@error('fecha_fin') {{ $message }} @enderror</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Motivo:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-earmark-medical"></i></span>
                            <textarea name="motivo" id="motivo" rows="1" maxlength="150"
                                      class="form-control @error('motivo') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;" required>{{ old('motivo') }}</textarea>
                            <div class="invalid-feedback d-block">@error('motivo') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Institución Médica:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <textarea name="institucion_medica" id="institucion_medica" rows="1" maxlength="150"
                                      class="form-control @error('institucion_medica') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;">{{ old('institucion_medica') }}</textarea>
                        </div>
                        <div class="invalid-feedback d-block">@error('institucion_medica') {{ $message }} @enderror</div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label fw-bold">Comprobante médico (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-paperclip"></i></span>
                            <input type="file" name="documento" id="documento"
                                   class="form-control @error('documento') is-invalid @enderror"
                                   accept=".pdf,.jpg,.jpeg,.png">
                            <div class="invalid-feedback d-block">@error('documento') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label class="form-label fw-bold">Descripción (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <textarea name="descripcion" id="descripcion" rows="3" maxlength="250"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      style="overflow:hidden; resize:none;">{{ old('descripcion') }}</textarea>
                            <div class="invalid-feedback d-block">@error('descripcion') {{ $message }} @enderror</div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label class="form-label fw-bold">Vista previa del comprobante:</label>
                        <div id="previewContainer" class="border p-2" style="min-height:150px;">
                        </div>
                    </div>

                    <div class="text-center mt-4 col-12">
                        <a href="{{ route('incapacidades.index') }}" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="button" class="btn btn-warning me-2" id="btnRestablecer">
                            <i class="bi bi-eraser-fill me-2"></i>Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i>Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const empleadoInput = document.getElementById('empleadoInput');
            const empleadoResults = document.getElementById('empleadoResults');
            const empleadoId = document.getElementById('empleado_id');
            const identidad = document.getElementById('identidad');
            const cargo = document.getElementById('cargo');
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const documento = document.getElementById('documento');
            const motivo = document.getElementById('motivo');
            const descripcion = document.getElementById('descripcion');
            const form = document.getElementById('incapacidadForm');
            const institucion = document.getElementById('institucion_medica');
            const previewContainer = document.getElementById('previewContainer');

            documento.addEventListener('change', function() {
                previewContainer.innerHTML = '';
                const file = this.files[0];
                if (!file) return;

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.maxWidth = '300px';
                    img.style.maxHeight = '300px';
                    img.classList.add('img-thumbnail');
                    previewContainer.appendChild(img);
                }

                else if (file.type === 'application/pdf') {
                    const iframe = document.createElement('iframe');
                    iframe.src = URL.createObjectURL(file);
                    iframe.style.width = '100%';
                    iframe.style.height = '400px';
                    iframe.classList.add('border');
                    previewContainer.appendChild(iframe);
                }

                else {
                    const p = document.createElement('p');
                    p.textContent = `Archivo seleccionado: ${file.name}`;
                    previewContainer.appendChild(p);
                }
            });

            document.getElementById('btnRestablecer').addEventListener('click', function(){
                previewContainer.innerHTML = '';
            });

            function setupTextareaLimit(id, maxLength) {
                const el = document.getElementById(id);
                el.addEventListener('input', function() {
                    if (this.value.length > maxLength) {
                        this.value = this.value.slice(0, maxLength);
                    }
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            }

            setupTextareaLimit('motivo', 150);
            setupTextareaLimit('descripcion', 250);
            setupTextareaLimit('institucion_medica', 150);

            institucion.addEventListener('input', function() {
                if (this.value.length > 150) {
                    this.value = this.value.slice(0, 150);
                }
            });

            const hoy = new Date();
            const año = hoy.getFullYear();
            const mes = hoy.getMonth();
            const primerDiaMesActualDate = new Date(año, mes, 1);
            const primerDiaMesActual = `${primerDiaMesActualDate.getFullYear()}-${String(primerDiaMesActualDate.getMonth() + 1).padStart(2, '0')}-01`;
            const ultimoDiaMesMasDosDate = new Date(año, mes + 3, 0);
            const ultimoDiaMesMasDos = `${ultimoDiaMesMasDosDate.getFullYear()}-${String(ultimoDiaMesMasDosDate.getMonth() + 1).padStart(2, '0')}-${String(ultimoDiaMesMasDosDate.getDate()).padStart(2, '0')}`;
            const maxFinGlobalDate = new Date(hoy.getFullYear(), hoy.getMonth() + 4, hoy.getDate());
            const maxFinGlobal = `${maxFinGlobalDate.getFullYear()}-${String(maxFinGlobalDate.getMonth() + 1).padStart(2, '0')}-${String(maxFinGlobalDate.getDate()).padStart(2, '0')}`;
            const hoyStr = `${año}-${String(hoy.getMonth() + 1).padStart(2, '0')}-${String(hoy.getDate()).padStart(2, '0')}`;

            if (!fechaInicio.value) fechaInicio.value = hoyStr;
            if (!fechaFin.value) fechaFin.value = hoyStr;

            fechaInicio.min = primerDiaMesActual;
            fechaInicio.max = ultimoDiaMesMasDos;

            fechaFin.min = hoyStr;
            fechaFin.max = maxFinGlobal;

            fechaInicio.addEventListener('change', function() {
                const inicioValor = this.value;
                if (inicioValor) {
                    fechaFin.min = inicioValor;
                    const maxFinDateDynamic = new Date(new Date(inicioValor).getFullYear(), new Date(inicioValor).getMonth() + 4, new Date(inicioValor).getDate());
                    fechaFin.max = `${maxFinDateDynamic.getFullYear()}-${String(maxFinDateDynamic.getMonth() + 1).padStart(2,'0')}-${String(maxFinDateDynamic.getDate()).padStart(2,'0')}`;
                    if (fechaFin.value && fechaFin.value < inicioValor) {
                        fechaFin.value = inicioValor;
                    }
                } else {
                    fechaFin.min = hoyStr;
                    fechaFin.max = maxFinGlobal;
                }
            });

            const empleados = @json($empleados);

            empleadoInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                empleadoResults.innerHTML = '';
                empleadoId.value = '';
                identidad.value = '';
                cargo.value = '';
                if (!query) return;
                const filtrados = empleados.filter(e => (e.nombre + ' ' + e.apellido).toLowerCase().includes(query));
                filtrados.forEach(emp => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.classList.add('list-group-item', 'list-group-item-action');
                    btn.textContent = emp.nombre + ' ' + emp.apellido;
                    btn.addEventListener('click', function() {
                        empleadoInput.value = emp.nombre + ' ' + emp.apellido;
                        empleadoId.value = emp.id;
                        identidad.value = emp.identidad;
                        cargo.value = emp.categoria;
                        empleadoResults.innerHTML = '';
                        empleadoInput.classList.remove('is-invalid');
                    });
                    empleadoResults.appendChild(btn);
                });
            });

            document.addEventListener('click', function(e) {
                if (!empleadoResults.contains(e.target) && e.target !== empleadoInput) {
                    empleadoResults.innerHTML = '';
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let isValid = true;
                document.querySelectorAll('.is-invalid').forEach(i => i.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(f => f.textContent = '');

                if (!empleadoId.value) {
                    empleadoInput.classList.add('is-invalid');
                    empleadoInput.closest('.col-md-5').querySelector('.invalid-feedback.d-block').textContent = 'Debe seleccionar un empleado.';
                    isValid = false;
                }

                if (!institucion.value.trim()) {
                    institucion.classList.add('is-invalid');
                    institucion.closest('.col-md-6').querySelector('.invalid-feedback.d-block').textContent = 'Debe ingresar la institución médica.';
                    isValid = false;
                }


                if (!motivo.value.trim()) {
                    motivo.classList.add('is-invalid');
                    motivo.nextElementSibling.textContent = 'Debe ingresar el motivo de la incapacidad.';
                    isValid = false;
                }

                if (!fechaInicio.value) {
                    fechaInicio.classList.add('is-invalid');
                    fechaInicio.closest('.col-md-4').querySelector('.invalid-feedback.d-block').textContent = 'Debe de seleccionar una fecha.';
                    isValid = false;
                }

                if (!fechaFin.value) {
                    fechaFin.classList.add('is-invalid');
                    fechaFin.closest('.col-md-4').querySelector('.invalid-feedback.d-block').textContent = 'Debe seleccionar una fecha.';
                    isValid = false;
                } else if (fechaInicio.value && fechaFin.value < fechaInicio.value) {
                    fechaFin.classList.add('is-invalid');
                    fechaFin.closest('.col-md-4').querySelector('.invalid-feedback.d-block').textContent = 'La fecha debe ser igual o posterior a la fecha de inicio.';
                    isValid = false;
                }

                if (isValid) form.submit();
            });

            document.getElementById('btnRestablecer').addEventListener('click', function(e){
                e.preventDefault();
                empleadoInput.value = '';
                empleadoId.value = '';
                identidad.value = '';
                cargo.value = '';
                motivo.value = '';
                descripcion.value = '';
                institucion.value = '';

                motivo.style.height = 'auto';
                descripcion.style.height = 'auto';
                institucion.style.height = 'auto';

                documento.value = '';
                document.querySelectorAll('.is-invalid').forEach(i => i.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(f => f.textContent = '');
                fechaInicio.value = hoyStr;
                fechaFin.value = hoyStr;
            });

        });
    </script>
    </body>
@endsection
