<?php $__env->startSection('content'); ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-hospital position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:3rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-clipboard2-pulse me-2"></i>Registrar Incapacidad
            </h3>

            <?php if(session('success')): ?>
                <div class="alert alert-success text-center">¡Incapacidad registrada correctamente!</div>
            <?php endif; ?>

            <form action="<?php echo e(route('incapacidades.store')); ?>" method="POST" enctype="multipart/form-data" id="incapacidadForm" novalidate>
                <?php echo csrf_field(); ?>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Empleado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   id="empleadoInput"
                                   name="empleado_nombre"
                                   class="form-control <?php $__errorArgs = ['empleado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Buscar empleado..."
                                   autocomplete="off"
                                   value="<?php echo e(old('empleado_nombre')); ?>">
                            <input type="hidden" name="empleado_id" id="empleado_id" value="<?php echo e(old('empleado_id')); ?>">
                        </div>
                        <div class="invalid-feedback d-block"><?php $__errorArgs = ['empleado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        <div id="empleadoResults" class="list-group" style="max-height:200px; overflow-y:auto;"></div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha inicio:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                   class="form-control <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('fecha_inicio')); ?>" required>
                        </div>
                        <div class="invalid-feedback d-block"><?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha fin:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                            <input type="date" name="fecha_fin" id="fecha_fin"
                                   class="form-control <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('fecha_fin')); ?>" required>
                        </div>
                        <div class="invalid-feedback d-block"><?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Motivo:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-earmark-medical"></i></span>
                            <textarea name="motivo" id="motivo" rows="3"
                                      class="form-control <?php $__errorArgs = ['motivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      style="overflow:hidden; resize:none;" required><?php echo e(old('motivo')); ?></textarea>
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['motivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Comprobante médico (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-paperclip"></i></span>
                            <input type="file" name="documento" id="documento"
                                   class="form-control <?php $__errorArgs = ['documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   accept=".pdf,.jpg,.jpeg,.png">
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Descripción (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <textarea name="descripcion" id="descripcion" rows="3"
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

                    <div class="text-center mt-4 col-12">
                        <a href="<?php echo e(route('incapacidades.index')); ?>" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="button" class="btn btn-warning me-2" id="btnRestablecer">
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
            const empleadoInput = document.getElementById('empleadoInput');
            const empleadoResults = document.getElementById('empleadoResults');
            const empleadoId = document.getElementById('empleado_id');
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const documento = document.getElementById('documento');
            const fileName = document.getElementById('fileName');
            const motivo = document.getElementById('motivo');
            const descripcion = document.getElementById('descripcion');
            const form = document.getElementById('incapacidadForm');

            const hoy = new Date();
            const año = hoy.getFullYear();
            const mes = String(hoy.getMonth() + 1).padStart(2, '0');
            const dia = String(hoy.getDate()).padStart(2, '0');
            const hoyStr = `${año}-${mes}-${dia}`;

            const primerDiaMes = `${año}-${mes}-01`;
            const ultimoDiaDate = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
            const ultimoDiaMes = `${ultimoDiaDate.getFullYear()}-${String(ultimoDiaDate.getMonth() + 1).padStart(2, '0')}-${String(ultimoDiaDate.getDate()).padStart(2, '0')}`;

            const maxFinDate = new Date(hoy.getFullYear(), hoy.getMonth() + 5, 0);
            const maxFinGlobal = `${maxFinDate.getFullYear()}-${String(maxFinDate.getMonth() + 1).padStart(2, '0')}-${String(maxFinDate.getDate()).padStart(2, '0')}`;

            if (!fechaInicio.value) fechaInicio.value = hoyStr;
            if (!fechaFin.value) fechaFin.value = hoyStr;

            fechaInicio.min = primerDiaMes;
            fechaInicio.max = ultimoDiaMes;
            fechaFin.min = hoyStr;
            fechaFin.max = maxFinGlobal;

            function forzarValorVacio(inputElement) {
                inputElement.addEventListener('input', function() {
                    if (!this.value) this.value = '';
                });
                inputElement.addEventListener('change', function() {
                    if (!this.value) this.value = '';
                });
            }
            forzarValorVacio(fechaInicio);
            forzarValorVacio(fechaFin);

            fechaInicio.addEventListener('change', function() {
                const inicioValor = this.value;
                if (inicioValor) {
                    fechaFin.min = inicioValor;
                    if (fechaFin.value && fechaFin.value < inicioValor) {
                        fechaFin.value = inicioValor;
                    }
                } else {
                    fechaFin.min = hoyStr;
                }
            });

            motivo.addEventListener('input', function() {
                if (this.value.length > 150) this.value = this.value.slice(0, 150);
            });

            descripcion.addEventListener('input', function() {
                if (this.value.length > 250) this.value = this.value.slice(0, 250);
            });

            documento.addEventListener('change', function() {
                fileName.textContent = this.files.length ? "Archivo seleccionado: " + this.files[0].name : "";
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                document.querySelectorAll('.is-invalid').forEach(i => i.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(f => f.textContent = '');

                let isValid = true;

                if (!empleadoId.value) {
                    empleadoInput.classList.add('is-invalid');
                    document.querySelector('.col-md-4 .invalid-feedback.d-block').textContent = 'Debe seleccionar un empleado.';
                    isValid = false;
                }

                if (!motivo.value.trim()) {
                    motivo.classList.add('is-invalid');
                    motivo.nextElementSibling.textContent = 'Debe ingresar el motivo de la incapacidad.';
                    isValid = false;
                }

                if (!fechaInicio.value) {
                    fechaInicio.classList.add('is-invalid');
                    fechaInicio.closest('.col-md-4').querySelector('.invalid-feedback.d-block').textContent = 'La fecha de inicio es obligatoria.';
                    isValid = false;
                }

                if (!fechaFin.value) {
                    fechaFin.classList.add('is-invalid');
                    fechaFin.closest('.col-md-4').querySelector('.invalid-feedback.d-block').textContent = 'La fecha de fin es obligatoria.';
                    isValid = false;
                } else if (fechaInicio.value && fechaFin.value < fechaInicio.value) {
                    fechaFin.classList.add('is-invalid');
                    fechaFin.closest('.col-md-4').querySelector('.invalid-feedback.d-block').textContent = 'La fecha debe ser igual o posterior a la fecha de inicio.';
                    isValid = false;
                }

                if (isValid) {
                    form.submit();
                }
            });

            document.getElementById('btnRestablecer').addEventListener('click', function(e){
                e.preventDefault();
                empleadoInput.value = '';
                empleadoId.value = '';
                empleadoResults.innerHTML = '';
                motivo.value = '';
                descripcion.value = '';
                documento.value = '';
                fileName.textContent = '';
                document.querySelectorAll('.is-invalid').forEach(i => i.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(f => f.textContent = '');
                fechaInicio.value = hoyStr;
                fechaFin.value = hoyStr;
            });

            const empleados = <?php echo json_encode($empleados, 15, 512) ?>;
            empleadoInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                empleadoResults.innerHTML = '';
                empleadoId.value = '';
                if (!query) return;
                const filtrados = empleados.filter(e => (e.nombre + ' ' + e.apellido).toLowerCase().includes(query));
                filtrados.forEach(emp => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.classList.add('list-group-item', 'list-group-item-action');
                    btn.textContent = emp.nombre + ' ' + emp.apellido;
                    btn.addEventListener('click', function() {
                        empleadoInput.value = emp.nombre + ' ' + emp.apellido;
                        empleadoId.value = emp.id;
                        empleadoResults.innerHTML = '';
                        empleadoInput.classList.remove('is-invalid');
                    });
                    empleadoResults.appendChild(btn);
                });
            });

            document.addEventListener('click', function(e) {
                if (!empleadoResults.contains(e.target) && e.target !== empleadoInput) {
                    empleadoResults.innerHTML = '';
                }
            });
        });
    </script>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/incapacidades/create.blade.php ENDPATH**/ ?>