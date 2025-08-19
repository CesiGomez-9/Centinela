<?php $__env->startSection('content'); ?>

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Instalación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }
        .form-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }
        .invalid-tooltip {
            background-color: transparent !important;
            border: 1px solid #dc3545 !important;
            color: #dc3545 !important;
            box-shadow: none !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.9rem !important;
            top: 100% !important;
            margin-top: 0.25rem !important;
            z-index: 10 !important;
            white-space: normal !important;
        }
        /* Para que el texto de los items en el dropdown se vea normal, sin cajas ni fondo */
        .ts-dropdown .option {
            background-color: transparent !important;
            color: #000 !important; /* texto negro normal */
            box-shadow: none !important;
            border: none !important;
            user-select: text !important; /* permitir selección normal */
        }

        /* Para quitar el hover que pinta el fondo */
        .ts-dropdown .option:hover {
            background-color: transparent !important;
            color: #000 !important;
        }

        /* Para quitar el fondo azul o selección */
        .ts-dropdown .option.active {
            background-color: transparent !important;
            color: #000 !important;
        }

        /* Evitar que el dropdown tenga sombras o bordes de color */
        .ts-dropdown {
            box-shadow: none !important;
            border: 1px solid #ccc !important; /* borde tenue para que se vea caja */
            background-color: white !important;
        }
        #cliente_id_ts-dropdown,
        #factura_id_ts-dropdown {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }

        .moneda-lempira {
            font-size: 1.1rem;
            color: #0a1f3a;
            user-select: none;
            font-weight: normal; /* Asegura que no sea negrita */
        }
        #cliente_id_ts-control input::selection,
        #factura_id_ts-control input::selection {
            background: transparent !important;
            color: inherit !important;
        }

        #cliente_id_ts-control input::-moz-selection,
        #factura_id_ts-control input::-moz-selection {
            background: transparent !important;
            color: inherit !important;
        }
        input.placeholder {
            color: #6c757d; /* gris placeholder */
            font-style: italic;
        }


    </style>
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-light p-5 rounded shadow-lg position-relative">

                <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                    <i class="bi bi-tools" style="font-size: 4rem;"></i>
                </div>

                <h3 class="text-center mb-4" style="color: #09457f;">
                    <i class="bi bi-gear-fill me-2"></i> Programar instalación
                </h3>

                <form action="<?php echo e(route('instalaciones.store')); ?>" method="POST" id="form-instalacion" novalidate>
                    <?php echo csrf_field(); ?>

                    <div class="row g-4">
                        
                        <!-- Cliente -->
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <select id="cliente_id" name="cliente_id">
                                    <option value="" ></option>
                                    <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cliente->id); ?>"><?php echo e($cliente->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Campo Fecha (sin error-tecnicos aquí) -->
                        <div class="col-md-6">
                            <label for="fecha_instalacion" class="form-label">Fecha de instalación</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" id="fecha_instalacion" name="fecha_instalacion"
                                       class="form-control <?php $__errorArgs = ['fecha_instalacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(now()->format('Y-m-d')); ?>"
                                       min="<?php echo e(now()->format('Y-m-d')); ?>" max="2025-10-31" required>
                                <?php $__errorArgs = ['fecha_instalacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <!-- No poner el div error-tecnicos aquí -->
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="empleado_id" class="form-label">Técnicos</label>
                            <div class="border rounded p-2" id="tecnicos-container" style="max-height: 150px; overflow-y: auto;">
                                <div class="row g-2">
                                    <?php $__currentLoopData = $tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-6 col-md-4">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="empleado_id[]"
                                                    value="<?php echo e($tecnico->id); ?>"
                                                    id="tecnico_<?php echo e($tecnico->id); ?>"
                                                    <?php echo e((collect(old('empleado_id'))->contains($tecnico->id) || (isset($instalacion) && $instalacion->tecnicos->contains($tecnico->id))) ? 'checked' : ''); ?>

                                                >
                                                <label class="form-check-label" for="tecnico_<?php echo e($tecnico->id); ?>">
                                                    <?php echo e($tecnico->nombre); ?>

                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Aquí sigue el mensaje de error -->
                            <div id="error-tecnicos" class="invalid-feedback d-block" style="margin-top:0.25rem;"></div>
                            <small class="text-muted">Seleccione uno o más técnicos.</small>
                        </div>


                        <!-- Servicio -->
                        <div class="col-md-6">
                            <label for="servicio_id" class="form-label">Servicio</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-list-task"></i></span>
                                <select id="servicio_id" name="servicio_id"
                                        class="form-select <?php $__errorArgs = ['servicio_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Seleccione un servicio</option>
                                    <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($servicio->id); ?>"><?php echo e($servicio->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['servicio_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Fecha instalación -->
                        <!-- Costo instalación -->
                        <div class="col-md-6">
                            <label for="costo_instalacion" class="form-label">Costo de Instalación (L.)</label>
                            <div class="input-group has-validation">
                                 <span class="input-group-text">
                                    <span class="moneda-lempira">L.</span>
                                  </span>
                                <input type="number" id="costo_instalacion" name="costo_instalacion"
                                       class="form-control <?php $__errorArgs = ['costo_instalacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       min="1" max="9999" step="0.01" placeholder="Ej: 500.00" required>
                                <?php $__errorArgs = ['costo_instalacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>


                        <!-- Factura (opcional) -->
                        <div class="col-md-6">
                            <label for="factura_id" class="form-label">Factura de Venta (Opcional)</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-receipt"></i></span>
                                <select id="factura_id" name="factura_id">
                                    <option value=""></option>
                                    <?php $__currentLoopData = $facturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $factura): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($factura->id); ?>">Factura #<?php echo e($factura->id); ?> - L. <?php echo e(number_format($factura->total, 2)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>


                        <!-- Descripción -->
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea  id="descripcion" name="descripcion" maxlength="255"
                                          class="form-control auto-expand <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          rows="2" required></textarea>
                                <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <textarea id="direccion" name="direccion" maxlength="255"
                                          class="form-control auto-expand <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          rows="2" required></textarea>
                                <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <div class="bg-light p-3 rounded shadow-sm" style="width: 300px; font-size: 0.9rem;">
                            <h6 class="text-center mb-3">Costos totales</h6>
                            <p class="d-flex justify-content-between mb-1">
                                <strong>Costo Factura:</strong>
                                <span>L. <span id="total-factura">0.00</span></span>
                            </p>
                            <p class="d-flex justify-content-between mb-1">
                                <strong>Costo Instalación:</strong>
                                <span>L. <span id="total-instalacion">0.00</span></span>
                            </p>
                            <hr>
                            <p class="d-flex justify-content-between fw-bold text-primary mb-1">
                                <span>Total General:</span>
                                <span>L. <span id="total-general">0.00</span></span>
                            </p>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center mt-4 d-flex justify-content-center gap-3">
                        <a href="<?php echo e(route('instalaciones.index')); ?>" class="btn btn-danger" type="button">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <button type="button" class="btn btn-warning" id="btn-limpiar">
                            <i class="bi bi-eraser-fill me-2"></i> Limpiar
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>


                    </div>
                </form>
                <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        ['#cliente_id', '#factura_id'].forEach(selector => {
                            new TomSelect(selector, {
                                create: false,
                                placeholder: document.querySelector(selector + ' option[value=""]').textContent,
                                allowEmptyOption: true,
                                dropdownParent: 'body',
                                maxOptions: 1000,
                                hideSelected: true,
                                render: {
                                    no_results: function() {
                                        return '<div class="no-results">No se encontraron resultados</div>';
                                    }
                                }
                            });
                        });

                        // === Variables del formulario ===
                        const form = document.getElementById("form-instalacion");
                        const fields = {
                            cliente: document.getElementById("cliente_id"),
                            servicio: document.getElementById("servicio_id"),
                            fecha: document.getElementById("fecha_instalacion"),
                            costo: document.getElementById("costo_instalacion"),
                            descripcion: document.getElementById("descripcion"),
                            direccion: document.getElementById("direccion"),
                            factura: document.getElementById("factura_id")
                        };
                        const tecnicosContainer = document.getElementById("tecnicos-container");
                        const totalFacturaSpan = document.getElementById("total-factura");
                        const totalInstalacionSpan = document.getElementById("total-instalacion");
                        const totalGeneralSpan = document.getElementById("total-general");
                        const errorTecnicos = document.getElementById('error-tecnicos');

                        // === Actualizar totales (solo refleja costo instalación) ===
                        function actualizarTotales() {
                            let [entero, decimal] = fields.costo.value.split(".");
                            if (entero.length > 4) entero = entero.slice(0, 4);
                            fields.costo.value = decimal !== undefined ? `${entero}.${decimal}` : entero;

                            const costo = parseFloat(fields.costo.value) || 0;

                            totalInstalacionSpan.textContent = costo.toFixed(2);
                            totalFacturaSpan.textContent = "0.00"; // se mantiene en cero
                            totalGeneralSpan.textContent = costo.toFixed(2); // solo refleja costo instalación
                        }
                        fields.costo.addEventListener("input", actualizarTotales);

                        // === Limpiar formulario ===
                        document.getElementById("btn-limpiar").addEventListener("click", () => {
                            form.reset();
                            totalFacturaSpan.textContent = "0.00";
                            totalInstalacionSpan.textContent = "0.00";
                            totalGeneralSpan.textContent = "0.00";
                            limpiarErrores();
                            errorTecnicos.textContent = '';
                            desbloquearTecnicos();
                        });

                        // === Evitar espacios al inicio ===
                        [fields.descripcion, fields.direccion].forEach(field => {
                            field.addEventListener("input", () => {
                                if (field.value.startsWith(" ")) field.value = field.value.trimStart();
                            });
                        });

                        // === Auto-ajuste dinámico para textareas ===
                        document.querySelectorAll(".auto-expand").forEach(textarea => {
                            textarea.style.overflow = "hidden";
                            textarea.addEventListener("input", () => {
                                textarea.style.height = "auto";
                                textarea.style.height = textarea.scrollHeight + "px";
                            });
                        });

                        // === Funciones de error ===
                        function setError(element, message) {
                            element.classList.add("is-invalid");
                            let feedback = element.parentNode.querySelector(".invalid-feedback");
                            if (!feedback) {
                                feedback = document.createElement("div");
                                feedback.className = "invalid-feedback";
                                element.parentNode.appendChild(feedback);
                            }
                            feedback.textContent = message;
                        }

                        function setGroupError(container, message) {
                            container.classList.add("is-invalid");
                            let feedback = container.parentNode.querySelector(".invalid-feedback");
                            if (!feedback) {
                                feedback = document.createElement("div");
                                feedback.className = "invalid-feedback";
                                feedback.style.display = "block";
                                container.parentNode.appendChild(feedback);
                            }
                            feedback.textContent = message;
                        }

                        function limpiarErrores() {
                            form.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));
                            form.querySelectorAll(".invalid-feedback").forEach(fb => fb.remove());
                        }

                        // === Validar formulario ===
                        form.addEventListener("submit", (e) => {
                            limpiarErrores();
                            let isValid = true;

                            // Limpiar espacios
                            fields.descripcion.value = fields.descripcion.value.trimStart();
                            fields.direccion.value = fields.direccion.value.trimStart();

                            // Cliente
                            if (!fields.cliente.value) { setError(fields.cliente, "Debe seleccionar un cliente."); isValid = false; }

                            // Técnicos
                            const tecnicosSeleccionados = document.querySelectorAll('input[name="empleado_id[]"]:checked');
                            if (tecnicosSeleccionados.length === 0) { setGroupError(tecnicosContainer, "Debe seleccionar al menos un técnico."); isValid = false; }

                            // Servicio
                            if (!fields.servicio.value) { setError(fields.servicio, "Debe seleccionar un servicio."); isValid = false; }

                            // Fecha
                            if (!fields.fecha.value) { setError(fields.fecha, "Debe ingresar una fecha de instalación."); isValid = false; }

                            // Costo
                            const costo = parseFloat(fields.costo.value);
                            if (isNaN(costo) || costo <= 0) { setError(fields.costo, "El costo debe ser mayor a 0."); isValid = false; }
                            else if (!/^\d{1,4}(\.\d+)?$/.test(fields.costo.value)) { setError(fields.costo, "El costo solo permite hasta 4 cifras enteras."); isValid = false; }

                            // Descripción
                            if (!fields.descripcion.value.trim()) { setError(fields.descripcion, "Debe ingresar una descripción."); isValid = false; }
                            else if (fields.descripcion.value.length > 255) { setError(fields.descripcion, "La descripción no puede superar los 255 caracteres."); isValid = false; }

                            // Dirección
                            if (!fields.direccion.value.trim()) { setError(fields.direccion, "Debe ingresar una dirección."); isValid = false; }
                            else if (fields.direccion.value.length > 255) { setError(fields.direccion, "La dirección no puede superar los 255 caracteres."); isValid = false; }

                            if (!isValid) e.preventDefault();
                        });

                        // === Desbloquear todos los técnicos ===
                        function desbloquearTecnicos() {
                            document.querySelectorAll('input[name="empleado_id[]"]').forEach(chk => {
                                chk.disabled = false;
                                chk.parentElement.classList.remove("text-muted");
                            });
                        }

                        // === Validar técnicos ocupados ===
                        async function validarTecnicosOcupados() {
                            const fecha = fields.fecha.value;
                            if (!fecha) { errorTecnicos.textContent = ''; desbloquearTecnicos(); return; }

                            // Obtener técnicos seleccionados
                            const seleccionados = Array.from(document.querySelectorAll('input[name="empleado_id[]"]:checked')).map(cb => parseInt(cb.value));

                            try {
                                const res = await fetch(`/api/tecnicos-ocupados?fecha=${fecha}`);
                                const ocupados = await res.json();

                                document.querySelectorAll('input[name="empleado_id[]"]').forEach(cb => {
                                    const id = parseInt(cb.value);
                                    if (ocupados.includes(id)) {
                                        cb.disabled = true;
                                        cb.parentElement.classList.add("text-muted");
                                    } else {
                                        cb.disabled = false;
                                        cb.parentElement.classList.remove("text-muted");
                                    }
                                });

                                // Mensaje de técnicos ocupados
                                const ocupadosSeleccionados = seleccionados.filter(id => ocupados.includes(id));
                                if (ocupadosSeleccionados.length > 0) {
                                    const nombres = ocupadosSeleccionados.map(id => {
                                        const label = document.querySelector(`input[name="empleado_id[]"][value="${id}"]`).nextElementSibling;
                                        return label ? label.textContent.trim() : id;
                                    });
                                    if (nombres.length === 1) errorTecnicos.textContent = `El técnico ${nombres[0]} está ocupado ese día.`;
                                    else {
                                        const ultimo = nombres.pop();
                                        errorTecnicos.textContent = `Los técnicos ${nombres.join(', ')} y ${ultimo} están ocupados ese día.`;
                                    }
                                } else errorTecnicos.textContent = '';

                            } catch {
                                errorTecnicos.textContent = 'Error al consultar técnicos ocupados.';
                            }
                        }

                        fields.fecha.addEventListener('change', validarTecnicosOcupados);
                        document.querySelectorAll('input[name="empleado_id[]"]').forEach(cb => cb.addEventListener('change', validarTecnicosOcupados));

                        // === Limitar texto en descripción y dirección ===
                        [fields.descripcion, fields.direccion].forEach(field => {
                            field.setAttribute('maxlength', '255');
                            field.addEventListener('keydown', e => {
                                const allowedKeys = ["Backspace","Delete","ArrowLeft","ArrowRight","ArrowUp","ArrowDown","Tab","Home","End"];
                                if (field.value.length >= 255 && !allowedKeys.includes(e.key) && !e.ctrlKey && !e.metaKey) e.preventDefault();
                            });
                            field.addEventListener('paste', e => {
                                e.preventDefault();
                                const pasteText = (e.clipboardData || window.clipboardData).getData('text').substring(0, 255 - field.value.length);
                                const start = field.selectionStart, end = field.selectionEnd;
                                field.value = field.value.slice(0,start) + pasteText + field.value.slice(end);
                                field.setSelectionRange(start + pasteText.length, start + pasteText.length);
                                field.dispatchEvent(new Event('input'));
                            });
                        });

                    });
                </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/instalaciones/formulario.blade.php ENDPATH**/ ?>