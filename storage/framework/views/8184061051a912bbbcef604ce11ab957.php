<?php $__env->startSection('content'); ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-pencil-square position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:3rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-clipboard2-pulse me-2"></i>Editar Incapacidad </h3>

            <?php if(session('success')): ?>
                <div class="alert alert-success text-center">¡Cambios guardados correctamente!</div>
            <?php endif; ?>

            <form action="<?php echo e(route('incapacidades.update', $incapacidad->id)); ?>" method="POST" enctype="multipart/form-data" id="incapacidadForm" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row g-4">

                    
                    <div class="col-md-6 position-relative">
                        <label class="form-label fw-bold">Empleado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" id="empleadoInput" readonly
                                   class="form-control"
                                   value="<?php echo e($incapacidad->empleado->nombre); ?> <?php echo e($incapacidad->empleado->apellido); ?>"
                                   data-original-name="<?php echo e($incapacidad->empleado->nombre); ?> <?php echo e($incapacidad->empleado->apellido); ?>">
                            <input type="hidden" name="empleado_id" id="empleado_id"
                                   value="<?php echo e($incapacidad->empleado_id); ?>"
                                   data-original-id="<?php echo e($incapacidad->empleado_id); ?>">
                        </div>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Identidad:</label>
                        <input type="text" id="identidad" class="form-control" readonly
                               value="<?php echo e($incapacidad->empleado->identidad); ?>"
                               data-original="<?php echo e($incapacidad->empleado->identidad); ?>">
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cargo:</label>
                        <input type="text" id="cargo" class="form-control" readonly
                               value="<?php echo e($incapacidad->empleado->categoria); ?>"
                               data-original="<?php echo e($incapacidad->empleado->categoria); ?>">
                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha inicio:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="fecha_inicio" class="form-control"
                                   value="<?php echo e(\Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('Y-m-d')); ?>"
                                   min="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"
                                   max="<?php echo e(\Carbon\Carbon::now()->addMonths(2)->format('Y-m-d')); ?>"
                                   data-original="<?php echo e(\Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('Y-m-d')); ?>">
                        </div>
                        <div class="invalid-feedback">Seleccione una fecha de inicio válida (hoy hasta 2 meses).</div>
                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha fin:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                            <input type="date" name="fecha_fin" class="form-control"
                                   value="<?php echo e(\Carbon\Carbon::parse($incapacidad->fecha_fin)->format('Y-m-d')); ?>"
                                   min="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"
                                   max="<?php echo e(\Carbon\Carbon::now()->addMonths(2)->format('Y-m-d')); ?>"
                                   data-original="<?php echo e(\Carbon\Carbon::parse($incapacidad->fecha_fin)->format('Y-m-d')); ?>">
                        </div>
                        <div class="invalid-feedback">Seleccione una fecha de fin válida (no antes de inicio y hasta 2 meses).</div>
                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Institución Médica:</label>
                        <textarea maxlength="50"
                                  name="institucion_medica" rows="1"
                                  class="form-control solo-texto"
                                  style="overflow:hidden; resize:none;"
                                  data-original="<?php echo e($incapacidad->institucion_medica); ?>"><?php echo e($incapacidad->institucion_medica); ?></textarea>
                        <div class="invalid-feedback">Institución médica obligatoria (máx 50 caracteres, sin símbolos).</div>
                    </div>

                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Asunto:</label>
                        <textarea maxlength="50"
                                  name="motivo" rows="1"
                                  class="form-control solo-texto"
                                  style="overflow:hidden; resize:none;"
                                  data-original="<?php echo e($incapacidad->motivo); ?>"><?php echo e($incapacidad->motivo); ?></textarea>
                        <div class="invalid-feedback">Debe ingresar un motivo válido.</div>
                    </div>

                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Comprobante médico:</label>
                        <input type="file" name="documento" class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png" id="documentoInput">
                        <div class="invalid-feedback">Debe adjuntar un comprobante válido.</div>
                    </div>

                    
                    <div class="col-md-6 ">
                        <label class="form-label fw-bold">Descripción:</label>
                        <textarea maxlength="250" name="descripcion" rows="4"
                                  class="form-control"
                                  style="overflow:hidden; resize:none;"
                                  data-original="<?php echo e($incapacidad->descripcion); ?>"><?php echo e($incapacidad->descripcion); ?></textarea>
                        <div class="invalid-feedback">La descripción es obligatoria.</div>
                    </div>

                    
                    <div class="col-md-6 ">
                        <label class="form-label fw-bold">Vista previa:</label>
                        <div id="vistaDocumento" class="border p-2 text-center mt-2">
                            <?php if($incapacidad->documento): ?>
                                <?php if(Str::endsWith($incapacidad->documento, ['.jpg','.jpeg','.png'])): ?>
                                    <img src="<?php echo e(asset('storage/'.$incapacidad->documento)); ?>" class="img-fluid rounded" style="max-height:200px;">
                                <?php elseif(Str::endsWith($incapacidad->documento, '.pdf')): ?>
                                    <iframe src="<?php echo e(asset('storage/'.$incapacidad->documento)); ?>" width="100%" height="200px" class="border"></iframe>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted">No hay documento cargado</p>
                            <?php endif; ?>
                        </div>

                        
                        <div id="originalVista" class="d-none">
                            <?php if($incapacidad->documento): ?>
                                <?php if(Str::endsWith($incapacidad->documento, ['.jpg','.jpeg','.png'])): ?>
                                    <?php echo '<img src="'.asset('storage/'.$incapacidad->documento).'" class="img-fluid rounded" style="max-height:200px;">'; ?>

                                <?php elseif(Str::endsWith($incapacidad->documento, '.pdf')): ?>
                                    <?php echo '<iframe src="'.asset('storage/'.$incapacidad->documento).'" width="100%" height="200px" class="border"></iframe>'; ?>

                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo '<p class="text-muted">No hay documento cargado</p>'; ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="text-center mt-4 col-12">
                        <a href="<?php echo e(route('incapacidades.index')); ?>" class="btn btn-danger me-2">
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
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // NO PERMITIR CARACTERES ESPECIALES
            document.querySelectorAll(".solo-texto").forEach(input => {
                input.addEventListener("input", () => {
                    input.value = input.value.replace(/[^A-Za-z0-9ÁÉÍÓÚáéíóúñÑ,.() ]/g, "");
                });
            });

            const form = document.getElementById("incapacidadForm");
            const documentoInput = document.getElementById('documentoInput');
            const vista = document.getElementById("vistaDocumento");
            const fechaInicioInput = form.querySelector('[name="fecha_inicio"]');
            const fechaFinInput = form.querySelector('[name="fecha_fin"]');

            // Guardar HTML original de la vista (para restablecer)
            const originalVistaEl = document.getElementById('originalVista');
            const originalVistaHtml = originalVistaEl ? originalVistaEl.innerHTML : vista.innerHTML;

            let tempPreviewHtml = vista.innerHTML;

            // PREVISUALIZAR ARCHIVO NUEVO
            documentoInput.addEventListener("change", () => {
                const file = documentoInput.files[0];
                if (!file) return;

                const url = URL.createObjectURL(file);

                if (file.type.includes("pdf")) {
                    vista.innerHTML = `<iframe src="${url}" width="100%" height="200" class="border"></iframe>`;
                } else {
                    vista.innerHTML = `<img src="${url}" class="img-fluid rounded" style="max-height:200px;">`;
                }

                tempPreviewHtml = vista.innerHTML;
            });

            // QUITAR INVALID AL ESCRIBIR
            [fechaInicioInput, fechaFinInput].forEach(input => {
                input.addEventListener("input", () => input.classList.remove("is-invalid"));
            });

            form.addEventListener("submit", (e) => {
                let valido = true;

                const requeridos = ["motivo", "institucion_medica", "descripcion"];
                requeridos.forEach(name => {
                    const campo = form.querySelector(`[name="${name}"]`);
                    let feedback = campo.nextElementSibling;
                    if (!feedback || !feedback.classList.contains("invalid-feedback")) {
                        feedback = document.createElement("div");
                        feedback.className = "invalid-feedback";
                        campo.parentNode.appendChild(feedback);
                    }

                    if (!campo.value.trim()) {
                        campo.classList.add("is-invalid");
                        // Mensajes personalizados
                        if (name === "motivo") feedback.textContent = "Debe ingresar el motivo de la incapacidad.";
                        if (name === "institucion_medica") feedback.textContent = "Debe ingresar la institución médica.";
                        if (name === "descripcion") feedback.textContent = "Debe ingresar una descripción.";
                        valido = false;
                    } else {
                        campo.classList.remove("is-invalid");
                    }
                });

                // FECHAS
                let fi = fechaInicioInput.value ? new Date(fechaInicioInput.value) : null;
                let ff = fechaFinInput.value ? new Date(fechaFinInput.value) : null;

                let feedbackInicio = fechaInicioInput.nextElementSibling;
                if (!feedbackInicio || !feedbackInicio.classList.contains("invalid-feedback")) {
                    feedbackInicio = document.createElement("div");
                    feedbackInicio.className = "invalid-feedback";
                    fechaInicioInput.parentNode.appendChild(feedbackInicio);
                }

                let feedbackFin = fechaFinInput.nextElementSibling;
                if (!feedbackFin || !feedbackFin.classList.contains("invalid-feedback")) {
                    feedbackFin = document.createElement("div");
                    feedbackFin.className = "invalid-feedback";
                    fechaFinInput.parentNode.appendChild(feedbackFin);
                }

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

                // DOCUMENTO
                let feedbackDoc = documentoInput.nextElementSibling;
                if (!feedbackDoc || !feedbackDoc.classList.contains("invalid-feedback")) {
                    feedbackDoc = document.createElement("div");
                    feedbackDoc.className = "invalid-feedback";
                    documentoInput.parentNode.appendChild(feedbackDoc);
                }

                if (!documentoInput.files.length && !<?php echo json_encode($incapacidad->documento, 15, 512) ?>) {
                    documentoInput.classList.add("is-invalid");
                    feedbackDoc.textContent = "Debe ingresar un comprobante.";
                    valido = false;
                } else {
                    documentoInput.classList.remove("is-invalid");
                }

                // DUPLICADO
                <?php
                    $duplicada = \App\Models\Incapacidad::where('empleado_id', $incapacidad->empleado_id)
                        ->where('id','!=',$incapacidad->id)
                        ->whereDate('fecha_inicio', \Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('Y-m-d'))
                        ->exists();
                ?>
                if (<?php echo json_encode($duplicada, 15, 512) ?>) {
                    alert("Este empleado ya tiene una incapacidad registrada para esta fecha.");
                    valido = false;
                }

                if (!valido) {
                    e.preventDefault();
                    vista.innerHTML = tempPreviewHtml;
                }
            });

            // RESTABLECER
            document.getElementById("btnRestablecer").addEventListener("click", (e) => {
                e.preventDefault();
                form.querySelectorAll("[data-original]").forEach(el => {
                    if (el.dataset.original !== undefined) {
                        el.value = el.dataset.original;
                    } else if (el.dataset.originalId !== undefined) {
                        el.value = el.dataset.originalId;
                    } else if (el.dataset.originalName !== undefined) {
                        el.value = el.dataset.originalName;
                    }
                    el.classList.remove("is-invalid");
                });

                documentoInput.value = "";
                vista.innerHTML = originalVistaHtml;
                tempPreviewHtml = originalVistaHtml;
            });

        });
    </script>

    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/incapacidades/edit.blade.php ENDPATH**/ ?>