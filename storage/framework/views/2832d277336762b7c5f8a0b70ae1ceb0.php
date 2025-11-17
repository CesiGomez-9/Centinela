<?php $__env->startSection('content'); ?>

    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Capacitaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            max-width: 500px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-light p-5 rounded shadow-lg position-relative">

                <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                    <i class="bi bi-building" style="font-size: 4rem;"></i>
                </div>

                <h3 class="text-center mb-4" style="color: #09457f;">
                    <i class="bi bi-person-plus-fill me-2"></i> Editar una capacitación
                </h3>

                <style>
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
                </style>

                    <form id="form-curso" action="<?php echo e(route('capacitaciones.update', $capacitacion->id)); ?>" method="POST" enctype="multipart/form-data" novalidate>
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-4">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre de la institución</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-book-fill"></i></span>
                                    <input type="text" name="nombre"
                                           class="form-control"
                                           value="<?php echo e(old('nombre', $capacitacion->nombre)); ?>"
                                           maxlength="100"
                                           onkeypress="soloLetras(event)"
                                           onkeydown="bloquearEspacioAlInicio(event, this)"
                                           oninput="eliminarEspaciosIniciales(this)"
                                           required>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>

                            <!-- Correo -->
                            <div class="col-md-6">
                                <label for="correo" class="form-label">Correo de la institución</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" name="correo"
                                           class="form-control <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('correo', $capacitacion->correo)); ?>"
                                           maxlength="50"
                                           onkeydown="bloquearEspacioAlInicio(event, this)"
                                           oninput="eliminarEspaciosIniciales(this)"
                                           required>
                                </div>
                                <div class="invalid-feedback"><?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>

                            <!-- Contacto -->
                            <div class="col-md-6">
                                <label for="contacto" class="form-label">Contacto</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                    <input type="text" name="contacto"
                                           class="form-control <?php $__errorArgs = ['contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('contacto', $capacitacion->contacto)); ?>"
                                           maxlength="100"
                                           onkeypress="soloLetras(event)"
                                           onkeydown="bloquearEspacioAlInicio(event, this)"
                                           oninput="eliminarEspaciosIniciales(this)"
                                           required>
                                </div>
                                <div class="invalid-feedback"><?php $__errorArgs = ['contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="telefono"
                                           class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('telefono', $capacitacion->telefono)); ?>"
                                           maxlength="8"
                                           inputmode="numeric"
                                           pattern="[0-9]*"
                                           onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                           required>
                                </div>
                                <div class="invalid-feedback"><?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>

                            <div class="row g-4">
                                <!-- Modalidad -->
                                <div class="col-md-4">
                                    <label for="modalidad" class="form-label">Modalidad</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                        <select name="modalidad" class="form-select <?php $__errorArgs = ['modalidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="">Seleccione una modalidad</option>
                                            <option value="Presencial" <?php echo e(old('modalidad', $capacitacion->modalidad) == 'Presencial' ? 'selected' : ''); ?>>Presencial</option>
                                            <option value="Virtual" <?php echo e(old('modalidad', $capacitacion->modalidad) == 'Virtual' ? 'selected' : ''); ?>>Virtual</option>
                                            <option value="Mixta" <?php echo e(old('modalidad', $capacitacion->modalidad) == 'Mixta' ? 'selected' : ''); ?>>Mixta</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['modalidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>

                                <!-- Nivel -->
                                <div class="col-md-4">
                                    <label for="nivel" class="form-label">Nivel</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-bar-chart-fill"></i></span>
                                        <select name="nivel" class="form-select <?php $__errorArgs = ['nivel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="">Seleccione un nivel</option>
                                            <option value="Básico" <?php echo e(old('nivel', $capacitacion->nivel) == 'Básico' ? 'selected' : ''); ?>>Básico</option>
                                            <option value="Intermedio" <?php echo e(old('nivel', $capacitacion->nivel) == 'Intermedio' ? 'selected' : ''); ?>>Intermedio</option>
                                            <option value="Avanzado" <?php echo e(old('nivel', $capacitacion->nivel) == 'Avanzado' ? 'selected' : ''); ?>>Avanzado</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['nivel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>

                                <!-- Duración -->
                                <div class="col-md-4">
                                    <label for="duracion" class="form-label">Duración (días)</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                        <input type="number" name="duracion"
                                               class="form-control <?php $__errorArgs = ['duracion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               value="<?php echo e(old('duracion', $capacitacion->duracion)); ?>"
                                               min="1" max="15"
                                               oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);"
                                               required>
                                    </div>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['duracion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Fecha inicio -->
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
                                    <input type="date" name="fecha_inicio"
                                           class="form-control <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('fecha_inicio', $capacitacion->fecha_inicio->format('Y-m-d'))); ?>"
                                           <?php if($capacitacion->fecha_inicio->format('Y-m-d') >= date('Y-m-d')): ?>
                                               min="<?php echo e(date('Y-m-d')); ?>"
                                           <?php endif; ?>
                                           required>

                                </div>
                                <div class="invalid-feedback"><?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>

                            <!-- Fecha fin -->
                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-calendar-check-fill"></i></span>
                                    <input type="date" name="fecha_fin"
                                           class="form-control <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('fecha_fin', $capacitacion->fecha_fin->format('Y-m-d'))); ?>"
                                           <?php if($capacitacion->fecha_fin->format('Y-m-d') >= date('Y-m-d')): ?>
                                               min="<?php echo e(date('Y-m-d')); ?>"
                                           <?php endif; ?>
                                           required>

                                </div>
                                <div class="invalid-feedback"><?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <textarea name="descripcion"
                                              class="form-control auto-expand <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              maxlength="250"
                                              onkeydown="bloquearEspacioAlInicio(event, this)"
                                              oninput="eliminarEspaciosIniciales(this)"
                                              required
                                              style="overflow:hidden; min-height:80px; resize:none;"><?php echo e(old('descripcion', $capacitacion->descripcion)); ?></textarea>
                                </div>
                                <div class="invalid-feedback"><?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-6">
                                <label for="direccion" class="form-label">Dirección</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                    <textarea name="direccion"
                                              class="form-control auto-expand <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              maxlength="250"
                                              onkeydown="bloquearEspacioAlInicio(event, this)"
                                              oninput="eliminarEspaciosIniciales(this)"
                                              required
                                              style="overflow:hidden; min-height:80px; resize:none;"><?php echo e(old('direccion', $capacitacion->direccion)); ?></textarea>
                                </div>
                                <div class="invalid-feedback"><?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                            </div>

                        </div>

                        <div class="text-center mt-5 d-flex justify-content-center gap-3">
                            <a href="<?php echo e(route('capacitaciones.index')); ?>" class="btn btn-danger">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>

                            <button type="button" class="btn btn-warning" id="btnRestablecer">
                                <i class="bi bi-eraser-fill me-2"></i> Restablecer
                            </button>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save-fill me-2"></i> Guardar cambios
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


<script>
    document.addEventListener("DOMContentLoaded", function () {

        const form = document.getElementById('form-curso');
        const restablecerBtn = document.getElementById('btnRestablecer');

        // === Guardar valores originales desde Laravel ===
        const valoresOriginales = {
            nombre: <?php echo json_encode($capacitacion->nombre, 15, 512) ?>,
            correo: <?php echo json_encode($capacitacion->correo, 15, 512) ?>,
            contacto: <?php echo json_encode($capacitacion->contacto, 15, 512) ?>,
            telefono: <?php echo json_encode($capacitacion->telefono, 15, 512) ?>,
            modalidad: <?php echo json_encode($capacitacion->modalidad, 15, 512) ?>,
            nivel: <?php echo json_encode($capacitacion->nivel, 15, 512) ?>,
            duracion: <?php echo json_encode($capacitacion->duracion, 15, 512) ?>,
            fecha_inicio: <?php echo json_encode($capacitacion->fecha_inicio->format('Y-m-d'), 15, 512) ?>,
            fecha_fin: <?php echo json_encode($capacitacion->fecha_fin->format('Y-m-d'), 15, 512) ?>,
            descripcion: <?php echo json_encode($capacitacion->descripcion, 15, 512) ?>,
            direccion: <?php echo json_encode($capacitacion->direccion, 15, 512) ?>,
        };

        // === Función para mostrar error ===
        function mostrarError(campo, mensaje) {
            campo.classList.add('is-invalid');
            const feedback = campo.closest('.col-md-4, .col-md-6')?.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = mensaje;
                feedback.style.display = 'block';
            }
        }

        // === Función para limpiar error ===
        function limpiarError(campo) {
            campo.classList.remove('is-invalid');
            const feedback = campo.closest('.col-md-4, .col-md-6')?.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = '';
                feedback.style.display = 'none';
            }
        }

        // === Autoexpandir textareas ===
        function ajustarAlturaTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }
        form.querySelectorAll('textarea.auto-expand').forEach(el => {
            ajustarAlturaTextarea(el);
            el.addEventListener('input', () => ajustarAlturaTextarea(el));
        });

        // === Bloquear espacios al inicio ===
        window.bloquearEspacioAlInicio = function(event, input) {
            if (event.key === ' ' && input.selectionStart === 0) event.preventDefault();
        }

        // === Eliminar espacios iniciales automáticamente ===
        window.eliminarEspaciosIniciales = function(input) {
            input.value = input.value.replace(/^\s+/, '');
        }

        // === Limpiar errores al escribir o cambiar ===
        form.querySelectorAll('input, textarea, select').forEach(el => {
            el.addEventListener('input', () => limpiarError(el));
            el.addEventListener('change', () => limpiarError(el));
        });

        // === Mensajes personalizados ===
        const mensajes = {
            nombre: 'Por favor, ingresa el nombre de la institución.',
            correo: 'Por favor, ingresa el correo de la institución.',
            contacto: 'Por favor, ingresa el nombre de la persona de contacto.',
            telefono: 'Por favor, ingresa el número de teléfono.',
            modalidad: 'Por favor, selecciona la modalidad.',
            nivel: 'Por favor, selecciona el nivel.',
            duracion: 'Por favor, ingresa la duración en días.',
            duracion_min: 'La duración no puede ser menor a 1.',
            duracion_max: 'La duración no puede ser mayor a 15.',
            fecha_inicio: 'Por favor, selecciona la fecha de inicio.',
            fecha_fin: 'Por favor, selecciona la fecha de finalización.',
            descripcion: 'Por favor, ingresa una descripción.',
            direccion: 'Por favor, ingresa la dirección.',
        };

        // === Validación al enviar ===
        form.addEventListener('submit', function(e) {
            let valido = true;

            // Limpiar errores previos
            form.querySelectorAll('.is-invalid').forEach(c => limpiarError(c));

            form.querySelectorAll('input[required], textarea[required], select[required]').forEach(el => {
                const valor = el.value.trim();

                if (!valor) {
                    mostrarError(el, mensajes[el.name] || 'Este campo es obligatorio.');
                    valido = false;
                    return;
                }

                // 💡 Validación específica para duración
                if (el.name === 'duracion') {
                    const duracionValor = parseInt(valor, 10);

                    if (isNaN(duracionValor)) {
                        mostrarError(el, mensajes.duracion);
                        valido = false;
                    } else if (duracionValor < 1) {
                        mostrarError(el, mensajes.duracion_min);
                        valido = false;
                    } else if (duracionValor > 15) {
                        mostrarError(el, mensajes.duracion_max);
                        valido = false;
                    }
                }

                // === Otras validaciones específicas ===
                if (el.name === 'nombre' && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9.,\s]+$/.test(valor)) {
                    mostrarError(el, 'Solo se permiten letras, números, comas y puntos.');
                    valido = false;
                }

                if (el.name === 'contacto' && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(valor)) {
                    mostrarError(el, 'Solo se permiten letras y espacios.');
                    valido = false;
                }

                if (el.name === 'telefono' && !/^[2389]\d{7}$/.test(valor)) {
                    mostrarError(el, 'El número debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.');
                    valido = false;
                }

                if (el.name === 'correo' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor)) {
                    mostrarError(el, 'Ingrese un correo válido.');
                    valido = false;
                }
            });

            // === Validación de fechas ===
            const fechaInicio = form.querySelector('input[name="fecha_inicio"]');
            const fechaFin = form.querySelector('input[name="fecha_fin"]');
            if (fechaInicio.value && fechaFin.value && new Date(fechaFin.value) < new Date(fechaInicio.value)) {
                mostrarError(fechaFin, 'La fecha final no puede ser anterior a la fecha de inicio.');
                valido = false;
            }

            if (!valido) e.preventDefault();
        });

        // === Botón Restablecer ===
        restablecerBtn.addEventListener('click', function (e) {
            e.preventDefault();

            form.querySelectorAll('input, textarea, select').forEach(el => {
                if (valoresOriginales.hasOwnProperty(el.name)) {
                    el.value = valoresOriginales[el.name];
                } else {
                    el.value = '';
                }

                limpiarError(el);
                if (el.tagName === 'TEXTAREA') ajustarAlturaTextarea(el);
            });
        });
    });
</script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/capacitaciones/edit.blade.php ENDPATH**/ ?>