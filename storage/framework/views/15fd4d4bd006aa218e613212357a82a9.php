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
                    <i class="bi bi-person-plus-fill me-2"></i> Registrar una capacitación
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

                <form action="<?php echo e(route('capacitaciones.store')); ?>"  method="POST" id="form-curso" novalidate>
                    <?php echo csrf_field(); ?>

                    <div class="row g-4">

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre de la institución</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-book-fill"></i></span>
                                <input type="text" name="nombre"
                                       class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('nombre')); ?>"
                                       maxlength="100"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                <?php $__errorArgs = ['nombre'];
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
                                       value="<?php echo e(old('correo')); ?>"
                                       maxlength="50"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                <?php $__errorArgs = ['correo'];
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

                        <!-- contacto -->
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
                                       value="<?php echo e(old('contacto')); ?>"
                                       maxlength="100"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                <?php $__errorArgs = ['contacto'];
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


                        <!-- telefono de la institucion -->
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
                                       value="<?php echo e(old('telefono')); ?>"
                                       maxlength="8"
                                       onkeypress="soloNumeros(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                <?php $__errorArgs = ['telefono'];
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

                        <!-- Modalidad -->
                        <div class="col-md-6">
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
                                    <option value="Presencial" <?php echo e(old('modalidad') == 'Presencial' ? 'selected' : ''); ?>>Presencial</option>
                                    <option value="Virtual" <?php echo e(old('modalidad') == 'Virtual' ? 'selected' : ''); ?>>Virtual</option>
                                    <option value="Mixta" <?php echo e(old('modalidad') == 'Mixta' ? 'selected' : ''); ?>>Mixta</option>
                                </select>
                                <?php $__errorArgs = ['modalidad'];
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

                        <!-- Nivel -->
                        <div class="col-md-6">
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
                                    <option value="Básico" <?php echo e(old('nivel') == 'Básico' ? 'selected' : ''); ?>>Básico</option>
                                    <option value="Intermedio" <?php echo e(old('nivel') == 'Intermedio' ? 'selected' : ''); ?>>Intermedio</option>
                                    <option value="Avanzado" <?php echo e(old('nivel') == 'Avanzado' ? 'selected' : ''); ?>>Avanzado</option>
                                </select>
                                <?php $__errorArgs = ['nivel'];
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

                        <!-- Duración -->
                        <div class="col-md-6">
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
                                       value="<?php echo e(old('duracion')); ?>"
                                       min="1" max="1000"
                                       onkeypress="soloNumeros(event)"
                                       required>
                                <?php $__errorArgs = ['duracion'];
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

                        <div class="col-md-6">
                        </div>


                        <!-- Fecha de inicio -->
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
                                       value="<?php echo e(old('fecha_inicio')); ?>"
                                       required>
                                <?php $__errorArgs = ['fecha_inicio'];
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

                        <!-- Fecha de fin -->
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
                                       value="<?php echo e(old('fecha_fin')); ?>"
                                       required>
                                <?php $__errorArgs = ['fecha_fin'];
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




                        <!-- Descripción -->
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea name="descripcion"
                                          class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          maxlength="300"
                                          style="height: 100px; resize: none;"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this)"
                                          required><?php echo e(old('descripcion')); ?></textarea>
                                <?php $__errorArgs = ['descripcion'];
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

                        <!-- Temario -->
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                <textarea name="direccion"
                                          class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          maxlength="500"
                                          style="height: 100px; resize: none;"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this)"
                                          required><?php echo e(old('direccion')); ?></textarea>
                                <?php $__errorArgs = ['direccion'];
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


        </div>














        <div class="text-center mt-5 d-flex justify-content-center gap-3">


                        <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">
                            <i class="bi bi-eraser-fill me-2"></i> Limpiar
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Boton Limpiar -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const resetBtn = document.querySelector('button[type="reset"]');

        if (resetBtn) {
            resetBtn.addEventListener('click', function (e) {
                e.preventDefault();

                const form = this.closest('form');
                if (!form) return;

                // Limpiar manualmente cada campo
                form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(el => {
                    el.value = '';
                });

                form.querySelectorAll('select').forEach(el => {
                    el.selectedIndex = 0;
                });

                // Remover clases de validación
                form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                    el.classList.remove('is-valid', 'is-invalid');
                });

                // Limpiar mensajes de error si hay
                form.querySelectorAll('.text-danger').forEach(el => {
                    el.innerText = '';
                });
            });
        }
    });
</script>

<script>
    function validarSoloLetras(input) {
        input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
        if (input.value.length > 50) {
            input.value = input.value.substring(0, 50);
        }



    }






    document.addEventListener("DOMContentLoaded", function(){
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('.is-invalid'));
        tooltipTriggerList.forEach(function (element) {
            new bootstrap.Tooltip(element, { placement: 'right' });
        });
    });

    function soloLetras(e) {
        const key = e.key;
        const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]$/;
        if (!regex.test(key) && !['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'].includes(key)) {
            e.preventDefault();
        }



    }

    function soloNumeros(e) {
        const key = e.key;
        if (!/^[0-9]$/.test(key) && !['Backspace','Tab','ArrowLeft','ArrowRight','Delete'].includes(key)) {
            e.preventDefault();
        }
    }

    function validarTelefono(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 8) {
            input.value = input.value.substring(0, 8);
        }
        if (input.value.length > 0 && !['2','3', '8', '9'].includes(input.value[0])) {
            input.setCustomValidity("El teléfono debe iniciar con 2, 3, 8 o 9");
        } else {
            input.setCustomValidity("");
        }
    }

    function bloquearEspacioAlInicio(e, input) {
        if (e.key === ' ' && input.selectionStart === 0) {
            e.preventDefault();
        }
    }

    function eliminarEspaciosIniciales(input) {
        input.value = input.value.replace(/^\s+/, '');
    }

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




    }



</script>











<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/capacitaciones/formulario.blade.php ENDPATH**/ ?>