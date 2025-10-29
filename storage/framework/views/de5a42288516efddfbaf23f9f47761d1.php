<?php $__env->startSection('content'); ?>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-badge-ad-fill position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-badge-ad me-2"></i>Registrar nueva promoción
            </h3>

            <?php if(session('success')): ?>
                <div class="alert alert-success">¡Promoción guardada correctamente!</div>
            <?php endif; ?>

            <form action="<?php echo e(route('promociones.store')); ?>" method="POST" enctype="multipart/form-data" novalidate id="promocionForm">
                <?php echo csrf_field(); ?>
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
                                      rows="3" maxlength="250" style="overflow:hidden; resize:none;"><?php echo e(old('descripcion')); ?></textarea>
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
                                      rows="3" maxlength="150" style="overflow:hidden; resize:none;"><?php echo e(old('restriccion')); ?></textarea>
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

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Subir plantilla de promoción (opcional):</label>
                        <div class="input-group" id="fileInputContainer">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>

                            <?php if(old('base64_imagen')): ?>
                                <div id="persistedFileDisplay" class="form-control text-muted d-flex align-items-center bg-light">
                                    <?php echo e(old('old_file_name', 'Imagen cargada')); ?>

                                </div>

                                <input type="file" name="imagen" id="imagenInput" style="display:none;"
                                       class="form-control" accept="image/*">
                            <?php else: ?>
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
                                <div id="persistedFileDisplay" class="form-control text-muted d-flex align-items-center bg-light" style="display:none;">
                                </div>
                            <?php endif; ?>

                            <?php if($errors->has('imagen') && !old('base64_imagen')): ?>
                                <div class="invalid-feedback d-block"><?php echo e($errors->first('imagen')); ?></div>
                            <?php else: ?>
                                <div class="invalid-feedback d-block"></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <input type="hidden" name="base64_imagen" id="base64Imagen" value="<?php echo e(old('base64_imagen')); ?>">
                    <input type="hidden" name="old_file_name" id="oldFileName" value="<?php echo e(old('old_file_name')); ?>">

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Vista previa:</label>
                        <div class="preview-container border rounded shadow-sm overflow-hidden p-2 bg-light position-relative" id="previewCard">
                            <img id="previewImagen"
                                 src="<?php echo e(old('base64_imagen') ?: (old('imagen') ? asset('storage/promociones/' . old('imagen')) : asset('imagenes/plantilla_promocion.jpg'))); ?>"
                                 alt="Vista previa" class="w-100 rounded mb-3" style="object-fit:cover; max-height:400px;">
                            <div class="position-absolute top-50 start-50 translate-middle text-center p-3 bg-dark bg-opacity-50 rounded" style="max-width: 70%;">
                                <h5 id="previewNombre" class="fw-bold text-white mb-1">Nombre de la promoción:</h5>
                                <p id="previewDescripcion" class="text-white mb-1">Descripción:</p>
                                <p id="previewRestriccion" class="text-danger mb-1">Restricción:</p>
                                <p id="previewFechas" class="small text-white mb-0">Promoción válida desde: <span id="fechaInicioText"></span> hasta <span id="fechaFinText"></span></p>
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

    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Vista completa de la promoción</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center bg-black overflow-auto" style="min-height: 60vh;">
                    <div class="position-relative text-center w-30">
                        <img id="modalImagen"
                             src="<?php echo e(old('base64_imagen') ?: (old('imagen') ? asset('storage/promociones/' . old('imagen')) : asset('imagenes/plantilla_promocion.jpg'))); ?>"
                             class="w-50 h-auto rounded shadow" style="object-fit: contain;">

                        <div class="position-absolute top-50 start-50 translate-middle text-center p-3 bg-dark bg-opacity-50 rounded" style="max-width: 50%;">
                            <h3 id="modalNombre" class="fw-bold text-white mb-2">Nombre de la promoción:</h3>
                            <p id="modalDescripcion" class="text-white mb-1">Descripción:</p>
                            <p id="modalRestriccion" class="text-danger mb-1">Restricción:</p>
                            <p id="modalFechas" class="small text-white mb-0">Promoción válida desde: <span id="modalInicio"></span> hasta <span id="modalFin"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const hoy = new Date();
            const yyyy = hoy.getFullYear();
            const mm = String(hoy.getMonth() + 1).padStart(2,'0');
            const dd = String(hoy.getDate()).padStart(2,'0');
            const hoyStr = `${yyyy}-${mm}-${dd}`;

            let maxDate = new Date();
            maxDate.setMonth(maxDate.getMonth() + 4);
            const maxStr = `${maxDate.getFullYear()}-${String(maxDate.getMonth()+1).padStart(2,'0')}-${String(maxDate.getDate()).padStart(2,'0')}`;

            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const nombreInput = document.getElementById('nombre');
            const descripcion = document.getElementById('descripcion');
            const restriccion = document.getElementById('restriccion');

            const imagenInput = document.getElementById('imagenInput');
            const base64ImagenInput = document.getElementById('base64Imagen');
            const oldFileNameInput = document.getElementById('oldFileName');
            const persistedFileDisplay = document.getElementById('persistedFileDisplay');

            const previewImagen = document.getElementById('previewImagen');
            const modalImagen = document.getElementById('modalImagen');

            const previewNombre = document.getElementById('previewNombre');
            const previewDescripcion = document.getElementById('previewDescripcion');
            const previewRestriccion = document.getElementById('previewRestriccion');
            const fechaInicioText = document.getElementById('fechaInicioText');
            const fechaFinText = document.getElementById('fechaFinText');
            const modalNombre = document.getElementById('modalNombre');
            const modalDescripcion = document.getElementById('modalDescripcion');
            const modalRestriccion = document.getElementById('modalRestriccion');
            const modalInicio = document.getElementById('modalInicio');
            const modalFin = document.getElementById('modalFin');
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));

            let tempImagenData = "<?php echo e(old('base64_imagen')); ?>";
            let tempFileName = "<?php echo e(old('old_file_name')); ?>";

            const oldFechaInicio = "<?php echo e(old('fecha_inicio')); ?>";
            const oldFechaFin = "<?php echo e(old('fecha_fin')); ?>";

            if (oldFechaInicio === '' && !fechaInicio.classList.contains('is-invalid')) {
                fechaInicio.value = hoyStr;
            } else if (oldFechaInicio === '') {
                fechaInicio.value = '';
            }

            if (oldFechaFin === '' && !fechaFin.classList.contains('is-invalid')) {
                fechaFin.value = hoyStr;
            } else if (oldFechaFin === '') {
                fechaFin.value = '';
            }

            fechaInicio.min = hoyStr;
            fechaFin.min = hoyStr;
            fechaInicio.max = maxStr;
            fechaFin.max = maxStr;

            function formatoFecha(fecha){
                if(!fecha) return '';
                const partes = fecha.split('-');
                return `${partes[2]}/${partes[1]}/${partes[0]}`;
            }

            function actualizarVista(){

                previewNombre.textContent = "Nombre de la promoción: " + (nombreInput.value || '');
                previewDescripcion.textContent = "Descripción: " + (descripcion.value || '');
                previewRestriccion.textContent = "Restricción: " + (restriccion.value || '');

                fechaInicioText.textContent = fechaInicio.value ? formatoFecha(fechaInicio.value) : '';
                fechaFinText.textContent = fechaFin.value ? formatoFecha(fechaFin.value) : '';

                modalNombre.textContent = previewNombre.textContent;
                modalDescripcion.textContent = previewDescripcion.textContent;
                modalRestriccion.textContent = previewRestriccion.textContent;
                modalInicio.textContent = fechaInicioText.textContent;
                modalFin.textContent = fechaFinText.textContent;

                if(tempImagenData){
                    previewImagen.src = tempImagenData;
                    modalImagen.src = tempImagenData;

                    if(persistedFileDisplay) {
                        persistedFileDisplay.style.display = 'flex';
                        persistedFileDisplay.textContent = tempFileName || 'Imagen cargada';
                    }
                    if(imagenInput) imagenInput.style.display = 'none';
                } else {

                    const defaultImage = "<?php echo e(asset('imagenes/plantilla_promocion.jpg')); ?>";
                    previewImagen.src = defaultImage;
                    modalImagen.src = defaultImage;

                    if(imagenInput) imagenInput.style.display = 'block';
                    if(persistedFileDisplay) persistedFileDisplay.style.display = 'none';
                }
            }

            function limpiarFormulario() {

                nombreInput.value = '';
                descripcion.value = '';
                restriccion.value = '';
                fechaInicio.value = hoyStr;
                fechaFin.value = hoyStr;

                if(imagenInput) imagenInput.value = '';
                tempImagenData = null;
                tempFileName = null;
                base64ImagenInput.value = '';
                oldFileNameInput.value = '';

                if(imagenInput) imagenInput.style.display = 'block';
                if(persistedFileDisplay) persistedFileDisplay.style.display = 'none';

                actualizarVista();

                document.querySelectorAll('.invalid-feedback').forEach(f => f.textContent='');
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            }

            nombreInput.addEventListener('input', actualizarVista);
            descripcion.addEventListener('input', actualizarVista);
            restriccion.addEventListener('input', actualizarVista);
            fechaInicio.addEventListener('input', actualizarVista);
            fechaFin.addEventListener('input', actualizarVista);

            if(imagenInput) {
                imagenInput.addEventListener('change', function(){
                    if(this.files && this.files[0]){
                        const file = this.files[0];
                        const reader = new FileReader();
                        reader.onload = e => {
                            tempImagenData = e.target.result;
                            tempFileName = file.name;

                            base64ImagenInput.value = e.target.result;
                            oldFileNameInput.value = file.name;

                            actualizarVista();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        limpiarFormulario();
                    }
                });
            }

            document.getElementById('btnAmpliar').addEventListener('click', () => modal.show());
            document.getElementById('btnRestablecer').addEventListener('click', e=>{
                e.preventDefault();

                limpiarFormulario();
            });

            actualizarVista();

            if(tempImagenData && imagenInput) {
                imagenInput.style.display = 'none';
            }
        });
    </script>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/promociones/create.blade.php ENDPATH**/ ?>