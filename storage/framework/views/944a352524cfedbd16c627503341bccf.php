<?php $__env->startSection('titulo','Registrar un nuevo producto'); ?>
<?php $__env->startSection('content'); ?>

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
        }
        /* Ajuste para hacer la letra más pequeña en el formulario */
        .form-label, .form-control, .form-select, .input-group-text, .text-danger, .small {
            font-size: 0.875rem; /* 14px, un poco más pequeño que el tamaño por defecto */
        }
        h3 {
            font-size: 1.5rem; /* Ajustar el tamaño del título si es necesario */
        }
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-5 rounded shadow-lg position-relative">

                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-box-seam" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4" style="color: #09457f;">
                        <i class="bi bi-boxes me-2"></i>
                        <?php if(isset($producto)): ?>
                            Editar un producto
                        <?php else: ?>
                            Registrar un nuevo producto
                        <?php endif; ?>
                    </h3>


                    <form method="POST" action="<?php echo e(isset($producto) ? route('productos.update', $producto->id) : route('productos.store')); ?>" novalidate>
                        <?php echo csrf_field(); ?>
                        <?php if(isset($producto)): ?>
                            <?php echo method_field('PUT'); ?> 
                        <?php endif; ?>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="nombre" id="nombre" class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="30" value="<?php echo e(old('nombre', $producto->nombre ?? '')); ?>" onkeypress="return soloLetras(event)" required>
                                </div>
                                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="serie" class="form-label">Serie del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="serie" id="serie" class="form-control <?php $__errorArgs = ['serie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="10" value="<?php echo e(old('serie', $producto->serie ?? '')); ?>" onkeypress="validarTexto(event)" required>
                                </div>
                                <?php $__errorArgs = ['serie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="codigo" class="form-label">Código del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-qr-code"></i></span>
                                    <input type="text" name="codigo" id="codigo" class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           maxlength="10" value="<?php echo e(old('codigo', $producto->codigo ?? '')); ?>"
                                           onkeypress="validarTexto(event)" required>
                                </div>
                                <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="marca" class="form-label">Marca del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <input type="text" name="marca" id="marca" class="form-control <?php $__errorArgs = ['marca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="30" value="<?php echo e(old('marca', $producto->marca ?? '')); ?>" onkeypress="return validarDescripcion(event)" required>
                                </div>
                                <?php $__errorArgs = ['marca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>


                            <div class="col-md-6">
                                <label for="modelo" class="form-label">Modelo del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi-cpu"></i></span>
                                    <input type="text" name="modelo" id="modelo" class="form-control <?php $__errorArgs = ['modelo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="30" value="<?php echo e(old('modelo', $producto->modelo ?? '')); ?>" onkeypress="return validarDescripcion(event)" required>
                                </div>
                                <?php $__errorArgs = ['modelo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="categoria" class="form-label">Categoría</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                    <select name="categoria" id="categoria" class="form-select <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                            $categorias = [
                                                'Cámaras de seguridad',
                                                'Alarmas antirrobo',
                                                'Cerraduras inteligentes',
                                                'Sensores de movimiento',
                                                'Luces con sensor de movimiento',
                                                'Rejas o puertas de seguridad',
                                                'Sistema de monitoreo 24/7',
                                                'Implementos de seguridad',
                                            ];
                                        ?>
                                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cat); ?>" <?php echo e(old('categoria', $producto->categoria ?? '') === $cat ? 'selected' : ''); ?>>
                                                <?php echo e($cat); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                    <?php $__errorArgs = ['categoria'];
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
                                <label for="impuesto_id" class="form-label">Tipo de Impuesto</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-percent"></i></span>
                                    <select name="impuesto_id" id="impuesto_id" class="form-select <?php $__errorArgs = ['impuesto_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione una opción</option>
                                        
                                        <?php $__currentLoopData = $impuestos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $impuesto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($impuesto->id); ?>"
                                                <?php echo e(old('impuesto_id', $producto->impuesto_id ?? '') == $impuesto->id ? 'selected' : ''); ?>>
                                                <?php echo e($impuesto->nombre); ?> (<?php echo e($impuesto->porcentaje); ?>%) 
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['impuesto_id'];
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

                            <div class="col-12 ">
                                <label for="descripcion" class="form-label">Descripción del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text-fill"></i></span>
                                    <textarea name="descripcion" id="descripcion" rows="4" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="255" onkeypress="return validarDescripcion(event)" required><?php echo e(old('descripcion', $producto->descripcion ?? '')); ?></textarea>
                                </div>
                                <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                        </div>

                        <div class="text-center mt-5">
                            <a href="<?php echo e(route('productos.index')); ?>" class="btn btn-danger me-2">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>

                            <button type="reset" class="btn btn-warning me-2">
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
                    e.preventDefault(); // evita el comportamiento por defecto del botón reset

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
                    form.querySelectorAll('.text-danger, .invalid-feedback').forEach(el => {
                        el.innerText = '';
                    });

                    // El campo de cantidad ya no está en el formulario, así que no necesita ser reiniciado aquí.
                });
            }
        });
    </script>


    <!-- Validaciones JS -->
    <script>
        function soloLetras(e) {
            let key = e.keyCode || e.which;
            let tecla = String.fromCharCode(key).toLowerCase();
            let letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            let especiales = [8, 37, 39, 46];
            let input = e.target;

            if (tecla === '.' || tecla === "'" || (letras.indexOf(tecla) === -1 && !especiales.includes(key))) {
                e.preventDefault();
                return false;
            }

            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            if (key === 32) {
                const valor = input.value;
                const pos = input.selectionStart;
                if (valor.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }
            return true;
        }

        function validarTexto(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key);
            const input = e.target;

            // Evitar espacio al inicio
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            // Evitar múltiples espacios seguidos
            const pos = input.selectionStart;
            if (key === 32 && input.value.charAt(pos - 1) === ' ') {
                e.preventDefault();
                return false;
            }

            return true;
        }

        document.querySelector('input[name="codigo"]').addEventListener('input', function () {
            if (this.value.match(/^0+$/)) {
                this.value = '';
            }
        });

        document.querySelector('input[name="serie"]').addEventListener('input', function () {
            if (this.value.match(/^0+$/)) {
                this.value = '';
            }
        });


        function validarDescripcion(e) {
            const key   = e.keyCode || e.which;
            const char  = String.fromCharCode(key);
            const input = e.target;
            const pos   = input.selectionStart;

            // 1. Bloquear si primer carácter no es letra (solo letras al inicio)
            if (pos === 0 && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ]$/.test(char)) {
                e.preventDefault();
                return false;
            }

            // 2. Bloquear espacio al inicio
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            // 3. Bloquear espacios dobles
            if (key === 32) {
                const pos = input.selectionStart;
                if (input.value.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }

            // Permitir resto de caracteres
            return true;
        }


    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/productos/formulario.blade.php ENDPATH**/ ?>