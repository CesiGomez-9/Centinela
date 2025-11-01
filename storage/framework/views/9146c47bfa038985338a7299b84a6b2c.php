<?php $__env->startSection('content'); ?>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-percent position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-tags-fill me-2"></i>Registrar nuevo descuento
            </h3>

            <?php if(session('success')): ?>
                <div class="alert alert-success text-center">¡Descuento guardado correctamente!</div>
            <?php endif; ?>

            <form action="<?php echo e(route('descuentos.store')); ?>" method="POST" id="descuentoForm" novalidate>
                <?php echo csrf_field(); ?>
                <div class="row g-3">

                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre del descuento:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                            <input type="text" name="nombre" id="nombre"
                                   class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('nombre')); ?>">
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['nombre'];
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
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Fecha inicio:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                   class="form-control <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('fecha_inicio')); ?>">
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                    </div>

                    <!-- Fecha fin -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Fecha fin:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar2-check-fill"></i></span>
                            <input type="date" name="fecha_fin" id="fecha_fin"
                                   class="form-control <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('fecha_fin')); ?>">
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                    </div>
                    <!-- Producto (opcional) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Producto asociado (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                            <select name="producto_id" id="producto_id" class="form-select">
                                <option value="">-- Selecciona un producto --</option>
                                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($producto->id); ?>" <?php echo e(old('producto_id') == $producto->id ? 'selected' : ''); ?>>
                                        <?php echo e($producto->nombre); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <!-- Tipo -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipo:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-list-check"></i></span>
                            <select name="tipo" id="tipo" class="form-select <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="porcentaje" <?php echo e(old('tipo') == 'porcentaje' ? 'selected' : ''); ?>>Porcentaje (%)</option>
                                <option value="fijo" <?php echo e(old('tipo') == 'fijo' ? 'selected' : ''); ?>>Monto fijo</option>
                            </select>
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                    </div>

                    <!-- Valor -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Valor:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
                            <input type="number" name="valor" id="valor" step="0.01" min="0"
                                   class="form-control <?php $__errorArgs = ['valor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('valor')); ?>">
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['valor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Descripción:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span>
                            <textarea name="descripcion" id="descripcion" rows="3" maxlength="250"
                                      class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      style="overflow:hidden; resize:none;"><?php echo e(old('descripcion')); ?></textarea>
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                    </div>

                    <!-- Activo -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Estado:</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo"
                                <?php echo e(old('activo', true) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="activo">Activo</label>
                        </div>
                    </div>

                    <!-- Vista previa -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Vista previa:</label>
                        <div class="preview-container border rounded shadow-sm bg-light p-3 text-center">
                            <h5 id="previewNombre" class="fw-bold text-primary mb-1">Nombre del descuento</h5>
                            <p id="previewDescripcion" class="text-secondary mb-1">Descripción del descuento</p>
                            <p id="previewTipoValor" class="fw-semibold mb-1 text-success"></p>
                            <p id="previewFechas" class="small text-muted mb-0"></p>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center mt-4 col-12">
                        <a href="<?php echo e(route('descuentos.index')); ?>" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="reset" class="btn btn-warning me-2" id="btnRestablecer">
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
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const nombre = document.getElementById('nombre');
            const descripcion = document.getElementById('descripcion');
            const tipo = document.getElementById('tipo');
            const valor = document.getElementById('valor');

            const previewNombre = document.getElementById('previewNombre');
            const previewDescripcion = document.getElementById('previewDescripcion');
            const previewTipoValor = document.getElementById('previewTipoValor');
            const previewFechas = document.getElementById('previewFechas');

            const hoy = new Date().toISOString().split('T')[0];
            fechaInicio.min = hoy;
            fechaFin.min = hoy;

            function formatoFecha(fecha) {
                if (!fecha) return '';
                const partes = fecha.split('-');
                return `${partes[2]}/${partes[1]}/${partes[0]}`;
            }

            function actualizarPreview() {
                previewNombre.textContent = nombre.value || 'Nombre del descuento';
                previewDescripcion.textContent = descripcion.value || 'Descripción del descuento';

                const tipoTxt = tipo.value === 'porcentaje' ? `${valor.value || 0}% de descuento` : `L. ${valor.value || 0} de descuento`;
                previewTipoValor.textContent = tipoTxt;

                if (fechaInicio.value && fechaFin.value) {
                    previewFechas.textContent = `Válido del ${formatoFecha(fechaInicio.value)} al ${formatoFecha(fechaFin.value)}`;
                } else {
                    previewFechas.textContent = '';
                }
            }

            [nombre, descripcion, tipo, valor, fechaInicio, fechaFin].forEach(input => {
                input.addEventListener('input', actualizarPreview);
            });

            document.getElementById('btnRestablecer').addEventListener('click', e => {
                e.preventDefault();
                document.getElementById('descuentoForm').reset();
                actualizarPreview();
            });

            actualizarPreview();
        });
    </script>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/descuentos/create.blade.php ENDPATH**/ ?>