@extends('plantilla')
@section('content')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-pencil-square position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:3rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-clipboard2-pulse me-2"></i>Editar Incapacidad </h3>

            @if(session('success'))
                <div class="alert alert-success text-center">¡Cambios guardados correctamente!</div>
            @endif

            <form action="{{ route('incapacidades.update', $incapacidad->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="incapacidadForm">
                @csrf
                @method('PUT')


                <div class="row g-4">

                    {{-- EMPLEADO --}}
                    <div class="col-md-6 position-relative">
                        <label class="form-label fw-bold">Empleado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" id="empleadoInput" readonly
                                   class="form-control"
                                   value="{{ $incapacidad->empleado->nombre }} {{ $incapacidad->empleado->apellido }}"
                                   data-original-name="{{ $incapacidad->empleado->nombre }} {{ $incapacidad->empleado->apellido }}">
                            <input type="hidden" name="empleado_id" id="empleado_id"
                                   value="{{ $incapacidad->empleado_id }}"
                                   data-original-id="{{ $incapacidad->empleado_id }}">
                        </div>
                    </div>

                    {{-- IDENTIDAD --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Identidad:</label>
                        <input type="text" id="identidad" class="form-control" readonly
                               value="{{ $incapacidad->empleado->identidad }}"
                               data-original="{{ $incapacidad->empleado->identidad }}">
                    </div>

                    {{-- CARGO --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cargo:</label>
                        <input type="text" id="cargo" class="form-control" readonly
                               value="{{ $incapacidad->empleado->categoria }}"
                               data-original="{{ $incapacidad->empleado->categoria }}">
                    </div>

                    {{-- FECHA INICIO --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha inicio:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="fecha_inicio" class="form-control"
                                   value="{{ \Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('Y-m-d') }}"
                                   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   max="{{ \Carbon\Carbon::now()->addMonths(2)->format('Y-m-d') }}"
                                   data-original="{{ \Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('Y-m-d') }}">
                        </div>
                        <div class="invalid-feedback">Seleccione una fecha de inicio válida (hoy hasta 2 meses).</div>
                    </div>

                    {{-- FECHA FIN --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha fin:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                            <input type="date" name="fecha_fin" class="form-control"
                                   value="{{ \Carbon\Carbon::parse($incapacidad->fecha_fin)->format('Y-m-d') }}"
                                   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   max="{{ \Carbon\Carbon::now()->addMonths(2)->format('Y-m-d') }}"
                                   data-original="{{ \Carbon\Carbon::parse($incapacidad->fecha_fin)->format('Y-m-d') }}">
                        </div>
                        <div class="invalid-feedback">Seleccione una fecha de fin válida (no antes de inicio y hasta 2 meses).</div>
                    </div>

                    {{-- INSTITUCIÓN MEDICA --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Institución Médica:</label>
                        <textarea maxlength="50"
                                  name="institucion_medica" rows="1"
                                  class="form-control solo-texto"
                                  onkeydown="bloquearEspacioAlInicio(event, this)"
                                  oninput="eliminarEspaciosIniciales(this)"
                                  style="overflow:hidden; resize:none;"
                                  data-original="{{ $incapacidad->institucion_medica }}">{{ $incapacidad->institucion_medica }}</textarea>
                        <div class="invalid-feedback">Institución médica obligatoria (máx 50 caracteres, sin símbolos).</div>
                    </div>

                    {{-- MOTIVO --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Asunto:</label>
                        <textarea maxlength="50"
                                  name="motivo" rows="1"
                                  class="form-control solo-texto"
                                  onkeydown="bloquearEspacioAlInicio(event, this)"
                                  oninput="eliminarEspaciosIniciales(this)"
                                  style="overflow:hidden; resize:none;"
                                  data-original="{{ $incapacidad->motivo }}">{{ $incapacidad->motivo }}</textarea>
                        <div class="invalid-feedback">Debe ingresar un motivo válido.</div>
                    </div>

                    {{-- COMPROBANTE --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Comprobante médico:</label>
                        <input type="file" name="documento" class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png" id="documentoInput">
                        <div class="invalid-feedback">Debe adjuntar un comprobante válido.</div>
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="col-md-6 ">
                        <label class="form-label fw-bold">Motivo:</label>
                        <textarea maxlength="250" name="descripcion" rows="4"
                                  class="form-control"
                                  onkeydown="bloquearEspacioAlInicio(event, this)"
                                  oninput="eliminarEspaciosIniciales(this)"
                                  style="overflow:hidden; resize:none;"
                                  data-original="{{ $incapacidad->descripcion }}">{{ $incapacidad->descripcion }}</textarea>
                        <div class="invalid-feedback">La descripción es obligatoria.</div>
                    </div>

                    {{-- VISTA PREVIA --}}
                    <div class="col-md-6 ">
                        <label class="form-label fw-bold">Vista previa:</label>
                        <div id="vistaDocumento" class="border p-2 text-center mt-2">
                            @if($incapacidad->documento)
                                @if(Str::endsWith($incapacidad->documento, ['.jpg','.jpeg','.png']))
                                    <img src="{{ asset('storage/'.$incapacidad->documento) }}" class="img-fluid rounded" style="max-height:200px;">
                                @elseif(Str::endsWith($incapacidad->documento, '.pdf'))
                                    <iframe src="{{ asset('storage/'.$incapacidad->documento) }}" width="100%" height="200px" class="border"></iframe>
                                @endif
                            @else
                                <p class="text-muted">No hay documento cargado</p>
                            @endif
                        </div>

                        {{-- Contenedor oculto con la vista original para restaurar sin problemas --}}
                        <div id="originalVista" class="d-none">
                            @if($incapacidad->documento)
                                @if(Str::endsWith($incapacidad->documento, ['.jpg','.jpeg','.png']))
                                    {!! '<img src="'.asset('storage/'.$incapacidad->documento).'" class="img-fluid rounded" style="max-height:200px;">' !!}
                                @elseif(Str::endsWith($incapacidad->documento, '.pdf'))
                                    {!! '<iframe src="'.asset('storage/'.$incapacidad->documento).'" width="100%" height="200px" class="border"></iframe>' !!}
                                @endif
                            @else
                                {!! '<p class="text-muted">No hay documento cargado</p>' !!}
                            @endif
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <div class="text-center mt-4 col-12">
                        <a href="{{ route('incapacidades.index') }}" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="button" class="btn btn-warning me-2" id="btnRestablecer">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Restablecer
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i>Guardar Cambios
                        </button>
                    </div>

                </div>
            </form>

            @if ($errors->any())
                <div style="background: red; color: white; padding: 10px;">
                    <strong>Errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // --- Helpers ---
            const soloTextoSelector = ".solo-texto";
            // Booleano si existe documento guardado previamente (true/false)
            const tieneDocumentoAnterior = @json($incapacidad->documento ? true : false);

            // --- Elementos ---
            const form = document.getElementById("incapacidadForm");
            const documentoInput = document.getElementById('documentoInput');
            const vista = document.getElementById("vistaDocumento");
            const originalVistaEl = document.getElementById('originalVista');
            const originalVistaHtml = originalVistaEl ? originalVistaEl.innerHTML : vista.innerHTML;
            const fechaInicioInput = form.querySelector('[name="fecha_inicio"]');
            const fechaFinInput = form.querySelector('[name="fecha_fin"]');

            // Evitar caracteres no deseados en campos con clase .solo-texto
            document.querySelectorAll(soloTextoSelector).forEach(input => {
                input.addEventListener("input", () => {
                    // Permite letras, números y signos básicos (ajusta si quieres quitar números)
                    input.value = input.value.replace(/[^A-Za-z0-9ÁÉÍÓÚáéíóúñÑ,.() ]/g, "");
                });
            });


            // Vista previa de archivo nuevo
            let tempPreviewHtml = vista.innerHTML;
            documentoInput.addEventListener("change", () => {
                const file = documentoInput.files[0];
                if (!file) {
                    // si quita selección, restaurar preview temporal (no el original)
                    vista.innerHTML = tempPreviewHtml;
                    return;
                }
                const url = URL.createObjectURL(file);
                if (file.type === "application/pdf" || file.type.includes("pdf")) {
                    vista.innerHTML = `<iframe src="${url}" width="100%" height="200" class="border"></iframe>`;
                } else {
                    vista.innerHTML = `<img src="${url}" class="img-fluid rounded" style="max-height:200px;">`;
                }
                tempPreviewHtml = vista.innerHTML;
            });

            // Quitar 'is-invalid' al escribir en fechas
            [fechaInicioInput, fechaFinInput].forEach(input => {
                input.addEventListener("input", () => input.classList.remove("is-invalid"));
            });

            // Función auxiliar para crear/obtener invalid-feedback
            function getOrCreateFeedback(elem) {
                let fb = elem.nextElementSibling;
                if (!fb || !fb.classList.contains("invalid-feedback")) {
                    fb = document.createElement("div");
                    fb.className = "invalid-feedback";
                    elem.parentNode.appendChild(fb);
                }
                return fb;
            }

            // Submit: validación cliente
            form.addEventListener("submit", (e) => {
                let valido = true;

                // Campos requeridos
                const requeridos = ["motivo", "institucion_medica", "descripcion"];
                requeridos.forEach(name => {
                    const campo = form.querySelector(`[name="${name}"]`);
                    const feedback = getOrCreateFeedback(campo);
                    if (!campo.value || !campo.value.trim()) {
                        campo.classList.add("is-invalid");
                        if (name === "motivo") feedback.textContent = "Debe ingresar el motivo de la incapacidad.";
                        if (name === "institucion_medica") feedback.textContent = "Debe ingresar la institución médica.";
                        if (name === "descripcion") feedback.textContent = "Debe ingresar una descripción.";
                        valido = false;
                    } else {
                        campo.classList.remove("is-invalid");
                    }
                });

                // Fechas
                const feedbackInicio = getOrCreateFeedback(fechaInicioInput);
                const feedbackFin = getOrCreateFeedback(fechaFinInput);

                const fi = fechaInicioInput.value ? new Date(fechaInicioInput.value) : null;
                const ff = fechaFinInput.value ? new Date(fechaFinInput.value) : null;

                if (!fechaInicioInput.value) {
                    fechaInicioInput.classList.add("is-invalid");
                    feedbackInicio.textContent = "Debe seleccionar una fecha de inicio.";
                    valido = false;
                } else {
                    fechaInicioInput.classList.remove("is-invalid");
                }

                if (!fechaFinInput.value) {
                    fechaFinInput.classList.add("is-invalid");
                    feedbackFin.textContent = "Debe seleccionar una fecha de fin.";
                    valido = false;
                } else {
                    fechaFinInput.classList.remove("is-invalid");
                }

                if (fi && ff && ff < fi) {
                    fechaFinInput.classList.add("is-invalid");
                    feedbackFin.textContent = "La fecha fin debe ser igual o posterior a la fecha de inicio.";
                    valido = false;
                }

                // Documento: obligatorio SOLO si no hay documento previo y no se sube uno nuevo
                const feedbackDoc = getOrCreateFeedback(documentoInput);
                if (!documentoInput.files.length && !tieneDocumentoAnterior) {
                    documentoInput.classList.add("is-invalid");
                    feedbackDoc.textContent = "Debe ingresar un comprobante.";
                    valido = false;
                } else {
                    documentoInput.classList.remove("is-invalid");
                }

                // Si no es válido, prevenir envío y restaurar preview temporal
                if (!valido) {
                    e.preventDefault();
                    vista.innerHTML = tempPreviewHtml;
                    return false;
                }

                // Si es válido, permitimos el envío. No llamar e.preventDefault()
            });

            // RESTABLECER: restaurar valores originales guardados en data-*
            document.getElementById("btnRestablecer").addEventListener("click", (e) => {
                e.preventDefault();

                // Para cada elemento que tenga cualquier data-original*, restaurarlo si existe
                form.querySelectorAll("[data-original],[data-original-id],[data-original-name]").forEach(el => {
                    if (el.dataset.original !== undefined) {
                        el.value = el.dataset.original;
                    } else if (el.dataset.originalId !== undefined) {
                        el.value = el.dataset.originalId;
                    } else if (el.dataset.originalName !== undefined) {
                        el.value = el.dataset.originalName;
                    }
                    el.classList.remove("is-invalid");
                });

                // limpiar input file y restaurar vista original
                documentoInput.value = "";
                vista.innerHTML = originalVistaHtml;
                tempPreviewHtml = originalVistaHtml;
            });

        });
    </script>


    </body>
@endsection
