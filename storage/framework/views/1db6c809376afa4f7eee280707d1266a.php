<?php $__env->startSection('content'); ?>
    <head>
        <meta charset="UTF-8" />
        <title>Editar Servicio</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
        <style>
            body {
                background-color: #e6f0ff;
                font-size: 1.1rem;
            }
            .form-contenedor {
                max-width: 1000px;
                margin: auto;
                background-color: white;
                padding: 2.5rem;
                border-radius: 1rem;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            }
            .was-validated .form-control:valid,
            .was-validated .form-select:valid,
            .was-validated textarea:valid {
                background-image: none !important;
                box-shadow: none !important;
            }
            .is-invalid + .text-danger.small,
            .is-invalid + .invalid-feedback,
            .is-invalid ~ .text-danger {
                display: block !important;
            }
            #servicioForm {
                font-size: 0.85rem;
            }
        </style>
    </head>
    <body>

    <div class="container my-3">
        <div class="form-contenedor position-relative">
            <h2 class="text-center mb-4 text-primary fs-8">
                <i class="bi bi-journal-plus me-2"></i> Editar un servicio
            </h2>

            <div class="position-absolute top-0 end-0 me-3 mt-2 d-none d-md-block" style="font-size: 4rem; color: #dce6f5;">
                <i class="bi bi-shield-lock"></i>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show py-2" role="alert" style="font-size: 0.85rem;">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <form id="servicioForm" action="<?php echo e(route('servicios.update', $servicio->id)); ?>" method="POST" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger mb-4">
                        <strong>Errores de validación:</strong>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-12 col-md-6">
                        <label for="nombreServicio" class="form-label fs-6 mb-2">Nombre del servicio</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" id="nombreServicio" name="nombreServicio"
                                   class="form-control <?php $__errorArgs = ['nombreServicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$"
                                   title="Solo letras, números y espacios, máximo 50 caracteres"
                                   value="<?php echo e(old('nombreServicio', $servicio->nombre)); ?>"
                                   onkeydown="bloquearEspacioAlInicio(event, this)"
                                   oninput="eliminarEspaciosIniciales(this)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un nombre válido.</div>
                        </div>
                        <?php $__errorArgs = ['nombreServicio'];
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

                    <!-- Costos -->
                    <div class="col-12 col-md-2">
                        <label for="costo_diurno" class="form-label fs-6 mb-2">Costo diurno</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-sun"></i></span>
                            <input type="number" step="0.01" min="1" max="9999"
                                   class="form-control <?php $__errorArgs = ['costo_diurno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="costo_diurno" name="costo_diurno"
                                   value="<?php echo e(old('costo_diurno', $servicio->costo_diurno)); ?>"
                                   oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo diurno válido.</div>
                        </div>
                        <?php $__errorArgs = ['costo_diurno'];
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

                    <div class="col-12 col-md-2">
                        <label for="costo_nocturno" class="form-label fs-6 mb-2">Costo nocturno</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-moon"></i></span>
                            <input type="number" step="0.01" min="1" max="9999"
                                   class="form-control <?php $__errorArgs = ['costo_nocturno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="costo_nocturno" name="costo_nocturno"
                                   value="<?php echo e(old('costo_nocturno', $servicio->costo_nocturno)); ?>"
                                   oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo nocturno válido.</div>
                        </div>
                        <?php $__errorArgs = ['costo_nocturno'];
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

                    <div class="col-12 col-md-2">
                        <label for="costo_24_horas" class="form-label fs-6 mb-2">Costo 24 horas</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            <input type="number" step="0.01" min="1" max="9999"
                                   class="form-control <?php $__errorArgs = ['costo_24_horas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="costo_24_horas" name="costo_24_horas"
                                   value="<?php echo e(old('costo_24_horas', $servicio->costo_24_horas)); ?>"
                                   oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo de 24 horas válido.</div>
                        </div>
                        <?php $__errorArgs = ['costo_24_horas'];
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

                    <!-- Descripción y categoría productos -->
                    <div class="col-12 col-md-6">
                        <label for="descripcionServicio" class="form-label fs-6 mb-2">Descripción</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                            <textarea id="descripcionServicio" name="descripcionServicio"
                                      class="form-control <?php $__errorArgs = ['descripcionServicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      maxlength="125" rows="1"
                                      onkeydown="bloquearEspacioAlInicio(event, this)"
                                      oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                      style="overflow:hidden; resize:none;"
                                      required><?php echo e(old('descripcionServicio', $servicio->descripcion)); ?></textarea>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese una descripción válida.</div>
                        </div>
                        <?php $__errorArgs = ['descripcionServicio'];
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

                    <div class="col-12 col-md-6">
                        <label class="form-label fs-6 mb-2">Productos requeridos</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                            <select id="productosCategoria" name="productos_categoria" class="form-select">
                                <option value="">Seleccione una categoría</option>
                                <option value="vigilancia" <?php echo e(old('productos_categoria', $servicio->categoria) === 'vigilancia' ? 'selected' : ''); ?>>Vigilancia</option>
                                <option value="tecnico" <?php echo e(old('productos_categoria', $servicio->categoria) === 'tecnico' ? 'selected' : ''); ?>>Técnico</option>
                            </select>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Seleccione una categoría.</div>
                        </div>
                        <?php $__errorArgs = ['productos_categoria'];
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

                    <!-- Checkboxes productos -->
                    <div class="col-12 d-none mt-2" id="productos_vigilancia">
                        <label class="form-label fw-semibold">Productos de vigilancia</label>
                        <div class="row row-cols-1 row-cols-md-2 g-1">
                            <?php $__currentLoopData = $productosVigilancia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="productos[]" value="<?php echo e($producto->id); ?>"
                                               id="vig_<?php echo e(Str::slug($producto->nombre, '_')); ?>"
                                            <?php echo e(in_array($producto->id, old('productos', $productosSeleccionados)) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="vig_<?php echo e(Str::slug($producto->nombre, '_')); ?>">
                                            <?php echo e($producto->nombre); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="col-12 d-none mt-2" id="productos_tecnico">
                        <label class="form-label fw-semibold">Productos técnicos</label>
                        <div class="row row-cols-1 row-cols-md-2 g-1">
                            <?php $__currentLoopData = $productosTecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="productos[]" value="<?php echo e($producto->id); ?>"
                                               id="tec_<?php echo e(Str::slug($producto->nombre, '_')); ?>"
                                            <?php echo e(in_array($producto->id, old('productos', $productosSeleccionados)) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="tec_<?php echo e(Str::slug($producto->nombre, '_')); ?>">
                                            <?php echo e($producto->nombre); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center mt-4">
                        <a href="<?php echo e(route('servicios.catalogo')); ?>" class="btn btn-danger me-2"><i class="bi bi-x-circle me-2"></i>Cancelar</a>
                        <button type="reset" class="btn btn-warning me-2"><i class="bi bi-eraser-fill me-2"></i>Restablecer</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i>Guardar Cambios</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function autoExpand(textarea){
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }

        function bloquearEspacioAlInicio(e, input){
            if(e.key === ' ' && input.selectionStart === 0) e.preventDefault();
        }

        function limitarDigitos(input, maxDigits){
            if(input.value.length > maxDigits) input.value = input.value.slice(0, maxDigits);
        }

        window.addEventListener('DOMContentLoaded', () => {
            const descripcion = document.getElementById('descripcionServicio');
            if(descripcion){
                autoExpand(descripcion);
                descripcion.addEventListener('input', ()=> autoExpand(descripcion));
            }

            const selectCategoria = document.getElementById('productosCategoria');
            const vigilanciaDiv = document.getElementById('productos_vigilancia');
            const tecnicoDiv = document.getElementById('productos_tecnico');

            function updateProductVisibility(){
                vigilanciaDiv.classList.add('d-none');
                tecnicoDiv.classList.add('d-none');
                if(selectCategoria.value === 'vigilancia') vigilanciaDiv.classList.remove('d-none');
                else if(selectCategoria.value === 'tecnico') tecnicoDiv.classList.remove('d-none');
            }

            // ✅ Mostrar productos seleccionados al cargar la página
            // Usa el valor actual del select (old() o $servicio->categoria)
            updateProductVisibility();

            selectCategoria.addEventListener('change', updateProductVisibility);

            const form = document.getElementById('servicioForm');
            form.addEventListener('submit', function(e){
                if(!form.checkValidity()){
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            form.addEventListener('reset', function(){
                vigilanciaDiv.classList.add('d-none');
                tecnicoDiv.classList.add('d-none');
                form.classList.remove('was-validated');
                form.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                selectCategoria.selectedIndex = 0;
            });
        });

    </script>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/servicios/edit.blade.php ENDPATH**/ ?>