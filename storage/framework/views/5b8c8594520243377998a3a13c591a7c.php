<?php $__env->startSection('content'); ?>
    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-pencil-square position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-pencil-fill me-2"></i>Editar promoción
            </h3>

            <?php if(session('success')): ?>
                <div class="alert alert-success">¡Cambios guardados correctamente!</div>
            <?php endif; ?>

            <form action="<?php echo e(route('promociones.update', $promocion->id)); ?>" method="POST" enctype="multipart/form-data" id="promocionForm" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre de la promoción:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                            <input type="text" id="nombre" name="nombre"
                                   class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('nombre', $promocion->nombre)); ?>">
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
                                   value="<?php echo e(old('fecha_inicio', $promocion->fecha_inicio)); ?>">
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
                                   value="<?php echo e(old('fecha_fin', $promocion->fecha_fin)); ?>">
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

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Descripción:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span>
                            <textarea name="descripcion" id="descripcion"
                                      class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      rows="3" maxlength="250" style="overflow:hidden; resize:none;"><?php echo e(old('descripcion', $promocion->descripcion)); ?></textarea>
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

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Restricción:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-exclamation-triangle-fill"></i></span>
                            <textarea name="restriccion" id="restriccion"
                                      class="form-control <?php $__errorArgs = ['restriccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      rows="3" maxlength="150" style="overflow:hidden; resize:none;"><?php echo e(old('restriccion', $promocion->restriccion)); ?></textarea>
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['restriccion'];
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
                        <label class="form-label fw-bold">Actualizar imagen (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>
                            <input type="file" name="imagen" id="imagenInput"
                                   class="form-control <?php $__errorArgs = ['imagen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   accept="image/*">
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['imagen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                    </div>

                    
                    <input type="hidden" name="previewImagen" id="previewImagenHidden"
                           value="<?php echo e(old('previewImagen', $promocion->imagen ? asset('storage/'.$promocion->imagen) : asset('imagenes/plantilla_promocion.jpg'))); ?>">

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Vista previa:</label>
                        <div class="preview-container border rounded shadow-sm overflow-hidden p-2 bg-light position-relative" id="previewCard">
                            <img id="previewImagen"
                                 src="<?php echo e(old('previewImagen', $promocion->imagen ? asset('storage/'.$promocion->imagen) : asset('imagenes/plantilla_promocion.jpg'))); ?>"
                                 alt="Vista previa" class="w-100 rounded mb-3" style="object-fit:cover; max-height:400px;">
                            <div class="position-absolute top-50 start-50 translate-middle text-center p-3 bg-dark bg-opacity-50 rounded" style="max-width: 70%;">
                                <h5 id="previewNombre" class="fw-bold text-white mb-1"></h5>
                                <p id="previewDescripcion" class="text-white mb-1"></p>
                                <p id="previewRestriccion" class="text-white mb-1"></p>
                                <p id="previewFechas" class="small text-white mb-0">
                                    Promoción válida desde: <span id="fechaInicioText"></span> hasta <span id="fechaFinText"></span>
                                </p>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnAmpliar">
                                <i class="bi bi-arrows-fullscreen"></i> Ampliar vista
                            </button>
                        </div>
                    </div>

                    <div class="text-center mt-4 col-12">
                        <a href="<?php echo e(route('promociones.index')); ?>" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="button" class="btn btn-warning me-2" id="btnRestablecer">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Restablecer
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i>Guardar cambios
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="text-white">Vista completa de la promoción</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center bg-black overflow-auto" style="min-height: 60vh;">
                    <div class="position-relative text-center w-30">
                        <img id="modalImagen"
                             src="<?php echo e(old('previewImagen', $promocion->imagen ? asset('storage/'.$promocion->imagen) : asset('imagenes/plantilla_promocion.jpg'))); ?>"
                             class="w-50 h-auto rounded shadow" style="object-fit: contain;">
                        <div class="position-absolute top-50 start-50 translate-middle text-center p-3 bg-dark bg-opacity-50 rounded" style="max-width: 50%;">
                            <h3 id="modalNombre" class="fw-bold text-white mb-2"></h3>
                            <p id="modalDescripcion" class="text-white mb-1"></p>
                            <p id="modalRestriccion" class="text-white mb-1"></p>
                            <p id="modalFechas" class="small text-white mb-0">
                                Promoción válida desde: <span id="modalInicio"></span> hasta <span id="modalFin"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const nombreInput = document.getElementById('nombre');
            const descripcionInput = document.getElementById('descripcion');
            const restriccionInput = document.getElementById('restriccion');
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const imagenInput = document.getElementById('imagenInput');
            const previewHidden = document.getElementById('previewImagenHidden');

            const previewNombre = document.getElementById('previewNombre');
            const previewDescripcion = document.getElementById('previewDescripcion');
            const previewRestriccion = document.getElementById('previewRestriccion');
            const fechaInicioText = document.getElementById('fechaInicioText');
            const fechaFinText = document.getElementById('fechaFinText');

            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            const modalNombre = document.getElementById('modalNombre');
            const modalDescripcion = document.getElementById('modalDescripcion');
            const modalRestriccion = document.getElementById('modalRestriccion');
            const modalInicio = document.getElementById('modalInicio');
            const modalFin = document.getElementById('modalFin');
            const modalImagen = document.getElementById('modalImagen');

            const originalData = {
                nombre: <?php echo json_encode($promocion->nombre, 15, 512) ?>,
                descripcion: <?php echo json_encode($promocion->descripcion, 15, 512) ?>,
                restriccion: <?php echo json_encode($promocion->restriccion, 15, 512) ?>,
                fecha_inicio: <?php echo json_encode($promocion->fecha_inicio, 15, 512) ?>,
                fecha_fin: <?php echo json_encode($promocion->fecha_fin, 15, 512) ?>
            };

            // Mantener imagen seleccionada incluso tras validación
            let ultimaImagenSeleccionada = previewHidden.value;

            function formatoFecha(fecha) {
                if(!fecha) return '';
                const d = new Date(fecha);
                return `${String(d.getDate()).padStart(2,'0')}/${String(d.getMonth()+1).padStart(2,'0')}/${d.getFullYear()}`;
            }

            function actualizarVista() {
                previewNombre.textContent = nombreInput.value ? "Nombre de la promoción: " + nombreInput.value : "Nombre de la promoción: " + originalData.nombre;
                previewDescripcion.textContent = descripcionInput.value ? "Descripción: " + descripcionInput.value : "Descripción: " + originalData.descripcion;
                previewRestriccion.textContent = restriccionInput.value ? "Restricción: " + restriccionInput.value : "Restricción: " + originalData.restriccion;
                fechaInicioText.textContent = fechaInicio.value ? formatoFecha(fechaInicio.value) : formatoFecha(originalData.fecha_inicio);
                fechaFinText.textContent = fechaFin.value ? formatoFecha(fechaFin.value) : formatoFecha(originalData.fecha_fin);

                modalNombre.textContent = previewNombre.textContent;
                modalDescripcion.textContent = previewDescripcion.textContent;
                modalRestriccion.textContent = previewRestriccion.textContent;
                modalInicio.textContent = fechaInicioText.textContent;
                modalFin.textContent = fechaFinText.textContent;
                modalImagen.src = ultimaImagenSeleccionada;
                document.getElementById('previewImagen').src = ultimaImagenSeleccionada;
                previewHidden.value = ultimaImagenSeleccionada;
            }

            descripcionInput.addEventListener('input', () => {
                if(descripcionInput.value.length > 250) descripcionInput.value = descripcionInput.value.slice(0,250);
            });
            restriccionInput.addEventListener('input', () => {
                if(restriccionInput.value.length > 150) restriccionInput.value = restriccionInput.value.slice(0,150);
            });

            imagenInput.addEventListener('change', function(){
                if(this.files && this.files[0]){
                    const reader = new FileReader();
                    reader.onload = e => {
                        ultimaImagenSeleccionada = e.target.result;
                        actualizarVista();
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            [nombreInput, descripcionInput, restriccionInput, fechaInicio, fechaFin].forEach(input => input.addEventListener('input', actualizarVista));

            document.getElementById('btnAmpliar').addEventListener('click', () => modal.show());

            document.getElementById('btnRestablecer').addEventListener('click', e => {
                e.preventDefault();
                nombreInput.value = originalData.nombre;
                descripcionInput.value = originalData.descripcion;
                restriccionInput.value = originalData.restriccion;
                fechaInicio.value = originalData.fecha_inicio;
                fechaFin.value = originalData.fecha_fin;
                actualizarVista();

                imagenInput.value = '';
                document.querySelectorAll('.invalid-feedback').forEach(f => { f.textContent=''; f.style.display='none'; });
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.alert').forEach(alert => alert.remove());
            });

            // Ejecutar al cargar la página para mantener imagen seleccionada tras validación
            actualizarVista();
        });
    </script>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/promociones/edit.blade.php ENDPATH**/ ?>