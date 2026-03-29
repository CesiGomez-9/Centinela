<?php $__env->startSection('content'); ?>

    <style>
        body {
            height: 100vh;
            margin: 0;
            background-color: #e6f0ff;
        }
        .form-contenedor {
            max-width: 1000px;
            margin: auto;
            background-color: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        /* Quitar icono check de validación en inputs, selects y textareas */
        .was-validated .form-control:valid,
        .was-validated .form-select:valid,
        .was-validated textarea:valid {
            background-image: none !important;
            box-shadow: none !important;
        }
        #servicioForm {
            font-size: 0.85rem;
        }
    </style>

    <body>

    <div class="container my-3">
        <div class="form-contenedor position-relative">
            <h2 class="text-center mb-4 text-primary fs-8">
                <i class="bi bi-journal-plus me-2"></i> Registrar un nuevo servicio
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

            <form id="servicioForm" action="<?php echo e(route('servicios.store')); ?>" method="POST" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="row g-3">

                    <!-- Nombre del servicio -->
                    <div class="col-12 col-md-6">
                        <label for="nombreServicio" class="form-label fs-6 mb-2">Nombre del servicio</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" id="nombreServicio" name="nombreServicio" class="form-control form-control-md"
                                   value="<?php echo e(old('nombreServicio')); ?>"
                                   maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                   title="Solo letras, máximo 50 caracteres"
                                   onkeydown="bloquearEspacioAlInicio(event, this)"
                                   oninput="eliminarEspaciosIniciales(this)"
                                   required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">
                                Ingrese un nombre válido (solo letras).
                            </div>
                        </div>
                        <?php if($errors->has('nombreServicio')): ?>
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">
                                <?php echo e($errors->first('nombreServicio')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Costo Diurno -->
                    <div class="col-12 col-md-2">
                        <label for="costo_diurno" class="form-label fs-6 mb-2">Costo diurno</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-sun"></i></span>
                            <input type="number" id="costo_diurno" name="costo_diurno" class="form-control form-control-md"
                                   value="<?php echo e(old('costo_diurno')); ?>" min="1" max="999999" oninput="limitarDigitos(this, 6)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo diurno válido.</div>
                        </div>
                        <?php if($errors->has('costo_diurno')): ?>
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">
                                <?php echo e($errors->first('costo_diurno')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Costo Nocturno -->
                    <div class="col-12 col-md-2">
                        <label for="costo_nocturno" class="form-label fs-6 mb-2">Costo nocturno</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-moon"></i></span>
                            <input type="number" id="costo_nocturno" name="costo_nocturno" class="form-control form-control-md"
                                   value="<?php echo e(old('costo_nocturno')); ?>" min="1" max="999999" oninput="limitarDigitos(this, 6)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo nocturno válido.</div>
                        </div>
                        <?php if($errors->has('costo_nocturno')): ?>
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">
                                <?php echo e($errors->first('costo_nocturno')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Costo 24 Horas -->
                    <div class="col-12 col-md-2">
                        <label for="costo_24_horas" class="form-label fs-6 mb-2">Costo 24 horas</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            <input type="number" step="0.01" id="costo_24_horas" name="costo_24_horas" class="form-control form-control-md"
                                   value="<?php echo e(old('costo_24_horas')); ?>" min="1" max="999999" oninput="limitarDigitos(this, 6)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo de 24 horas válido.</div>
                        </div>
                        <?php if($errors->has('costo_24_horas')): ?>
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">
                                <?php echo e($errors->first('costo_24_horas')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Descripción -->
                    <div class="col-12 col-md-6">
                        <label for="descripcionServicio" class="form-label fs-6 mb-2">Descripción</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                            <textarea id="descripcionServicio" name="descripcionServicio" class="form-control form-control-md"
                                      maxlength="125" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                      onkeydown="bloquearEspacioAlInicio(event, this)"
                                      oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                      title="Solo letras, máximo 125 caracteres"
                                      rows="1" required
                                      style="overflow:hidden; resize:none;"><?php echo e(old('descripcionServicio')); ?></textarea>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese una descripción válida.</div>
                        </div>
                        <?php if($errors->has('descripcionServicio')): ?>
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">
                                <?php echo e($errors->first('descripcionServicio')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Productos requeridos -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fs-6 mb-2">Productos requeridos</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                            <select class="form-select form-select-md" id="productosCategoria" name="productos_categoria" required>
                                <option value="">Seleccione una categoría</option>
                                <option value="vigilancia" <?php echo e(old('productos_categoria') == 'vigilancia' ? 'selected' : ''); ?>>Vigilancia</option>
                                <option value="tecnico" <?php echo e(old('productos_categoria') == 'tecnico' ? 'selected' : ''); ?>>Técnico</option>
                            </select>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Seleccione una categoría de productos.</div>
                        </div>
                        <?php if($errors->has('productos_categoria')): ?>
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">
                                <?php echo e($errors->first('productos_categoria')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Productos de vigilancia -->
                    <div class="col-12 <?php echo e(old('productos_categoria') != 'vigilancia' ? 'd-none' : ''); ?>" id="productos_vigilancia">
                        <label class="form-label fs-6 mb-2">Productos de vigilancia</label>
                        <div class="row g-2" style="font-size: 0.85rem;">
                            <?php $__currentLoopData = $productosVigilancia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="productos[]" value="<?php echo e($producto->id); ?>"
                                               id="vig_<?php echo e(Str::slug($producto->nombre, '_')); ?>"
                                            <?php echo e(is_array(old('productos')) && in_array($producto->id, old('productos')) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="vig_<?php echo e(Str::slug($producto->nombre, '_')); ?>">
                                            <?php echo e($producto->nombre); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Productos técnicos -->
                    <div class="col-12 <?php echo e(old('productos_categoria') != 'tecnico' ? 'd-none' : ''); ?>" id="productos_tecnico">
                        <label class="form-label fs-6 mb-2">Productos técnicos</label>
                        <div class="row g-2" style="font-size: 0.85rem;">
                            <?php $__currentLoopData = $productosTecnico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="productos[]" value="<?php echo e($producto->id); ?>"
                                               id="tec_<?php echo e(Str::slug($producto->nombre, '_')); ?>"
                                            <?php echo e(is_array(old('productos')) && in_array($producto->id, old('productos')) ? 'checked' : ''); ?>>
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
                        <a href="<?php echo e(route('servicios.catalogo')); ?>" class="btn btn-danger me-2" style="font-size: 0.85rem;">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <button type="button" id="btnReset" class="btn btn-warning me-2" style="font-size: 0.85rem;">
                            <i class="bi bi-eraser-fill me-2"></i> Limpiar
                        </button>

                        <button type="submit" class="btn btn-primary" style="font-size: 0.85rem;">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function autoExpand(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }

        window.addEventListener('DOMContentLoaded', () => {
            const textarea = document.getElementById('descripcionServicio');
            autoExpand(textarea);
        });

        function limitarDigitos(input, maxDigits) {
            let value = input.value;
            let parts = value.split('.');
            if (parts[0].length > maxDigits) parts[0] = parts[0].substring(0, maxDigits);
            if (parts[1] && parts[1].length > 2) parts[1] = parts[1].substring(0, 2);
            input.value = parts.join('.');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productosCategoriaSelect = document.getElementById('productosCategoria');
            const vigilanciaDiv = document.getElementById('productos_vigilancia');
            const tecnicoDiv = document.getElementById('productos_tecnico');
            const form = document.getElementById('servicioForm');

            // Mostrar productos según la categoría
            productosCategoriaSelect.addEventListener('change', function () {
                vigilanciaDiv.classList.add('d-none');
                tecnicoDiv.classList.add('d-none');
                if (this.value === 'vigilancia') vigilanciaDiv.classList.remove('d-none');
                if (this.value === 'tecnico') tecnicoDiv.classList.remove('d-none');
            });

            // Validación de solo letras
            function validarInput(e, pattern, maxLength) {
                const input = e.target;
                let valor = input.value;
                let regex = new RegExp(pattern, 'g');
                let soloPermitidos = valor.match(regex);
                valor = soloPermitidos ? soloPermitidos.join('') : '';
                if (valor.length > maxLength) valor = valor.substring(0, maxLength);
                input.value = valor;
            }
            document.getElementById('nombreServicio').addEventListener('input', e => validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 50));
            document.getElementById('descripcionServicio').addEventListener('input', e => {
                validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 125);
                autoExpand(e.target);
            });

            function bloquearEspacioAlInicio(e, input) {
                if (e.key === ' ' && input.selectionStart === 0) e.preventDefault();
            }

            // Validación al enviar formulario
            form.addEventListener('submit', function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            // Reset personalizado
            document.getElementById('btnReset').addEventListener('click', function(e){
                e.preventDefault();
                vigilanciaDiv.classList.add('d-none');
                tecnicoDiv.classList.add('d-none');
                form.classList.remove('was-validated');
                form.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(input => input.value = '');
                form.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
                form.querySelectorAll('.text-danger').forEach(err => err.remove());
                autoExpand(document.getElementById('descripcionServicio'));
            });

            // Quitar mensajes al corregir
            document.querySelectorAll('#servicioForm input, #servicioForm textarea, #servicioForm select').forEach(el => {
                el.addEventListener('input', () => {
                    el.closest('.form-group')?.querySelector('.text-danger')?.remove();
                    form.classList.remove('was-validated');
                });
            });
        });
    </script>

    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/servicios/index.blade.php ENDPATH**/ ?>