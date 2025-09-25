<?php $__env->startSection('content'); ?>


    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Cliente</title>
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
                    <i class="bi bi-person-plus-fill me-2"></i> Registrar un cliente
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

                <form action="<?php echo e(route('Clientes.store')); ?>" method="POST" id="form-cliente" novalidate>
                    <?php echo csrf_field(); ?>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre </label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
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
                                       maxlength="50"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
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
                            <label for="apellido" class="form-label">Apellido </label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="apellido"
                                       class="form-control <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('apellido')); ?>"
                                       maxlength="50"
                                       onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                                       required>
                                <?php $__errorArgs = ['apellido'];
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
                            <label for="identidad" class="form-label">Identidad</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></span>
                                <input type="text" id="identidad" name="identidad" maxlength="13"
                                       value="<?php echo e(old('identidad')); ?>"
                                       class="form-control <?php $__errorArgs = ['identidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       oninput="formatearIdentidad(this)" />
                                <?php $__errorArgs = ['identidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div id="errorIdentidad" class="invalid-feedback"></div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
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

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
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

                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <select name="departamento" class="form-select <?php $__errorArgs = ['departamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                                    <option value="">Seleccione un departamento</option>
                                    <option value="Atlántida" <?php echo e(old('departamento') == 'Atlántida' ? 'selected' : ''); ?>>Atlántida</option>
                                    <option value="Choluteca" <?php echo e(old('departamento') == 'Choluteca' ? 'selected' : ''); ?>>Choluteca</option>
                                    <option value="Colón" <?php echo e(old('departamento') == 'Colón' ? 'selected' : ''); ?>>Colón</option>
                                    <option value="Comayagua" <?php echo e(old('departamento') == 'Comayagua' ? 'selected' : ''); ?>>Comayagua</option>
                                    <option value="Copán" <?php echo e(old('departamento') == 'Copán' ? 'selected' : ''); ?>>Copán</option>
                                    <option value="Cortés" <?php echo e(old('departamento') == 'Cortés' ? 'selected' : ''); ?>>Cortés</option>
                                    <option value="El Paraíso" <?php echo e(old('departamento') == 'El Paraíso' ? 'selected' : ''); ?>>El Paraíso</option>
                                    <option value="Francisco Morazán" <?php echo e(old('departamento') == 'Francisco Morazán' ? 'selected' : ''); ?>>Francisco Morazán</option>
                                    <option value="Gracias a Dios" <?php echo e(old('departamento') == 'Gracias a Dios' ? 'selected' : ''); ?>>Gracias a Dios</option>
                                    <option value="Intibucá" <?php echo e(old('departamento') == 'Intibucá' ? 'selected' : ''); ?>>Intibucá</option>
                                    <option value="Islas de la Bahía" <?php echo e(old('departamento') == 'Islas de la Bahía' ? 'selected' : ''); ?>>Islas de la Bahía</option>
                                    <option value="La Paz" <?php echo e(old('departamento') == 'La Paz' ? 'selected' : ''); ?>>La Paz</option>
                                    <option value="Lempira" <?php echo e(old('departamento') == 'Lempira' ? 'selected' : ''); ?>>Lempira</option>
                                    <option value="Ocotepeque" <?php echo e(old('departamento') == 'Ocotepeque' ? 'selected' : ''); ?>>Ocotepeque</option>
                                    <option value="Olancho" <?php echo e(old('departamento') == 'Olancho' ? 'selected' : ''); ?>>Olancho</option>
                                    <option value="Santa Bárbara" <?php echo e(old('departamento') == 'Santa Bárbara' ? 'selected' : ''); ?>>Santa Bárbara</option>
                                    <option value="Valle" <?php echo e(old('departamento') == 'Valle' ? 'selected' : ''); ?>>Valle</option>
                                    <option value="Yoro" <?php echo e(old('departamento') == 'Yoro' ? 'selected' : ''); ?>>Yoro</option>
                                </select>
                                <?php $__errorArgs = ['departamento'];
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
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <textarea
                                    name="direccion"
                                    id="direccion"
                                    class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    maxlength="250"
                                    style="resize: none; overflow: hidden;"
                                    onkeydown="bloquearEspacioAlInicio(event, this)"
                                    oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                ><?php echo e(old('direccion')); ?></textarea>
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

                        <div class="col-md-6">
                            <label for="sexo" class="form-label">Sexo</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                <select name="sexo"
                                        id="sexo"
                                        class="form-select <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        >
                                    <option value="">Seleccione su sexo</option>
                                    <option value="Hombre" <?php echo e(old('sexo') == 'Hombre' ? 'selected' : ''); ?>>Hombre</option>
                                    <option value="Mujer" <?php echo e(old('sexo') == 'Mujer' ? 'selected' : ''); ?>>Mujer</option>
                                    <option value="Otros" <?php echo e(old('sexo') == 'Otros' ? 'selected' : ''); ?>>Otros</option>
                                </select>
                                <?php $__errorArgs = ['sexo'];
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




                        <div class="text-center mt-5 d-flex justify-content-center gap-3">
                        <!-- Botón Cancelar -->
                        <a href="<?php echo e(route('Clientes.indexCliente')); ?>" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>
                        <!-- Botón Limpiar -->
                        <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">
                            <i class="bi bi-eraser-fill me-2"></i> Limpiar
                        </button>

                        <!-- Botón Guardar -->
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>

                    </div>


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

                // Limpiar inputs de texto y números
                form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(el => {
                    el.value = '';
                    el.classList.remove('is-valid', 'is-invalid');
                });

                // Limpiar selects (sexo, departamento, etc.)
                form.querySelectorAll('select').forEach(el => {
                    el.selectedIndex = 0; // primera opción, normalmente el placeholder
                    el.classList.remove('is-valid', 'is-invalid');
                });

                // Eliminar clases generales de validación
                form.classList.remove('was-validated');

                // Limpiar mensajes de error Laravel (si están debajo del input)
                form.querySelectorAll('.text-danger').forEach(el => {
                    el.textContent = '';
                });

                // Si usas Laravel con errores en span.invalid-feedback, también:
                form.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.style.display = 'none';
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

    function validarIdentificacion(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 13) {
            input.value = input.value.substring(0, 13);
        }
        if (input.value.length >= 2) {
            const inicio = input.value.substring(0, 2);
            if (!/^(0[1-9]|1[0-3])$/.test(inicio)) {
                input.setCustomValidity("La identidad debe iniciar entre 01 y 13");
                return;
            }
        }
        input.setCustomValidity("");
    }

    function validarCorreo(input) {
        if (input.value.length > 100) {
            input.value = input.value.substring(0, 100);
        }
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(input.value)) {
            input.setCustomValidity("Correo no válido");
        } else {
            input.setCustomValidity("");
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

    function bloquearEspacioAlInicio(e, input) {
        if (e.key === ' ' && input.selectionStart === 0) {
            e.preventDefault();
        }
    }

    function formatearIdentidad(i) {

        let v = i.value.replace(/[^0-9]/g, '');
        if (v.length > 13) {
            v = v.slice(0, 13);
        }


        if (v.length >= 4) {
            const departamento = v.slice(0, 2);
            const municipio = v.slice(2, 4);

            if (!codigosDep.includes(departamento)) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'Código de departamento inválido.';
                i.value = v;
                return;
            } else if (!municipiosPorDepartamento[departamento] || !municipiosPorDepartamento[departamento].includes(municipio)) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'Código de municipio inválido para el departamento.';
                i.value = v;
                return;
            }
        } else if (v.length >= 2) {
            const departamento = v.slice(0, 2);
            if (!codigosDep.includes(departamento)) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'Código de departamento inválido.';
                i.value = v;
                return;
            }
        }
        if (v.length >= 8) {
            let anio = v.slice(4, 8);
            let anioNum = parseInt(anio, 10);

            if (isNaN(anioNum) || anioNum < 1940 || anioNum > 2007) {
                i.classList.add('is-invalid');
                document.getElementById('errorIdentidad').textContent = 'El año debe ser entre 1940 y 2007.';
                i.value = v;
                return;
            }
        }
        i.classList.remove('is-invalid');
        document.getElementById('errorIdentidad').textContent = '';
        i.value = v;
    }

    function eliminarEspaciosIniciales(input) {
        input.value = input.value.replace(/^\s+/, '');
    }

    function limpiarFormulario() {
        const form = document.getElementById('form-cliente');
        if (!form) return;

        // Limpiar valores de inputs y textarea
        form.querySelectorAll('input[type="text"], input[type="email"], textarea').forEach(input => {
            input.value = '';
            input.classList.remove('is-invalid', 'is-valid');
        });

        // Limpiar selects (departamento, sexo)
        form.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0;
            select.classList.remove('is-invalid', 'is-valid');
        });

        // Limpiar mensajes de error de Laravel / Bootstrap
        form.querySelectorAll('.invalid-feedback, .text-danger').forEach(el => {
            el.textContent = '';
            el.style.display = 'none'; // Opcional si usas display none para errores
        });

        // Quitar clase que muestra validación visual de bootstrap
        form.classList.remove('was-validated');

        // Opcional: poner foco en el primer campo
        const primerCampo = form.querySelector('input, select, textarea');
        if (primerCampo) primerCampo.focus();
    }



</script>


<script>
    function autoExpand(textarea) {
        textarea.style.height = 'auto'; // Reinicia altura
        textarea.style.height = (textarea.scrollHeight) + 'px'; // Ajusta a contenido
    }

    // Para ajustar si ya viene con texto viejo (old)
    window.addEventListener('DOMContentLoaded', () => {
        const direccion = document.getElementById('direccion');
        if (direccion) autoExpand(direccion);
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

<?php $__env->stopSection(); ?>






<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/Clientes/formulariocliente.blade.php ENDPATH**/ ?>