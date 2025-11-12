<?php $__env->startSection('content'); ?>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-pencil-square position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:3rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-clipboard2-pulse me-2"></i>Editar Incapacidad </h3>

            <?php if(session('success')): ?>
                <div class="alert alert-success text-center">¡Cambios guardados correctamente!</div>
            <?php endif; ?>

            <form action="<?php echo e(route('incapacidades.update', $incapacidad->id)); ?>" method="POST" enctype="multipart/form-data" id="incapacidadForm" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row g-4">

                    
                    <div class="col-md-6 position-relative">
                        <label class="form-label fw-bold">Empleado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" id="empleadoInput" name="empleado_nombre"
                                   class="form-control <?php $__errorArgs = ['empleado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Buscar empleado..."
                                   value="<?php echo e(old('empleado_nombre', $incapacidad->empleado->nombre . ' ' . $incapacidad->empleado->apellido)); ?>"
                                   data-original-name="<?php echo e($incapacidad->empleado->nombre); ?> <?php echo e($incapacidad->empleado->apellido); ?>"
                                   data-original-id="<?php echo e($incapacidad->empleado_id); ?>">
                            <input type="hidden" name="empleado_id" id="empleado_id"
                                   value="<?php echo e(old('empleado_id', $incapacidad->empleado_id)); ?>"
                                   data-original-id="<?php echo e($incapacidad->empleado_id); ?>">
                        </div>
                        <div class="invalid-feedback">Debe seleccionar un empleado válido antes de guardar.</div>
                        <?php $__errorArgs = ['empleado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div id="empleadoResults" class="list-group"
                             style="max-height:200px; overflow-y:auto; position:absolute; z-index:1000; width:100%;">
                        </div>
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Identidad:</label>
                        <input type="text" id="identidad" class="form-control" readonly
                               value="<?php echo e(old('empleado_identidad', $incapacidad->empleado->identidad)); ?>"
                               data-original="<?php echo e($incapacidad->empleado->identidad); ?>">
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cargo:</label>
                        <input type="text" id="cargo" class="form-control" readonly
                               value="<?php echo e(old('empleado_cargo', $incapacidad->empleado->categoria)); ?>"
                               data-original="<?php echo e($incapacidad->empleado->categoria); ?>">
                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha inicio:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="fecha_inicio"
                                   class="form-control"
                                   value="<?php echo e(old('fecha_inicio', \Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('Y-m-d'))); ?>"
                                   data-original="<?php echo e(\Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('Y-m-d')); ?>">
                        </div>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha fin:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                            <input type="date" name="fecha_fin"
                                   class="form-control"
                                   value="<?php echo e(old('fecha_fin', \Carbon\Carbon::parse($incapacidad->fecha_fin)->format('Y-m-d'))); ?>"
                                   data-original="<?php echo e(\Carbon\Carbon::parse($incapacidad->fecha_fin)->format('Y-m-d')); ?>">
                        </div>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>

                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Motivo:</label>
                        <textarea name="motivo" rows="1" maxlength="150"
                                  class="form-control"
                                  style="overflow:hidden; resize:none;"
                                  data-original="<?php echo e($incapacidad->motivo); ?>"><?php echo e(old('motivo', $incapacidad->motivo)); ?></textarea>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>

                    
                    <div class="col-md-12 row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Institución Médica:</label>
                            <textarea name="institucion_medica" rows="1" maxlength="150"
                                      class="form-control"
                                      style="overflow:hidden; resize:none;"
                                      data-original="<?php echo e($incapacidad->institucion_medica); ?>"><?php echo e(old('institucion_medica', $incapacidad->institucion_medica)); ?></textarea>
                            <div class="invalid-feedback">Este campo es obligatorio.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Comprobante médico:</label>
                            <input type="file" name="documento" class="form-control" accept=".pdf,.jpg,.jpeg,.png" id="documentoInput">
                            <div class="invalid-feedback">Debe subir un documento válido.</div>
                        </div>
                    </div>

                    
                    <div class="col-md-12 row g-4 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Descripción (opcional):</label>
                            <textarea name="descripcion" rows="4" maxlength="250"
                                      class="form-control"
                                      style="overflow:hidden; resize:none;"
                                      data-original="<?php echo e($incapacidad->descripcion); ?>"><?php echo e(old('descripcion', $incapacidad->descripcion)); ?></textarea>
                            <div class="invalid-feedback">Este campo es obligatorio.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Vista previa del comprobante:</label>
                            <div id="vistaDocumento" class="border p-2 text-center mt-2">
                                <?php if($incapacidad->documento): ?>
                                    <?php if(Str::endsWith($incapacidad->documento, ['.jpg','.jpeg','.png'])): ?>
                                        <img src="<?php echo e(asset('storage/'.$incapacidad->documento)); ?>" class="img-fluid rounded" style="max-height:200px;">
                                    <?php elseif(Str::endsWith($incapacidad->documento, '.pdf')): ?>
                                        <iframe src="<?php echo e(asset('storage/'.$incapacidad->documento)); ?>" width="100%" height="200px" class="border"></iframe>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="text-muted">No hay documento cargado</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="text-center mt-4 col-12">
                        <a href="<?php echo e(route('incapacidades.index')); ?>" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="button" class="btn btn-warning me-2" id="btnRestablecer">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Restablecer
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i>Guardar Cambios
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const empleados = <?php echo json_encode($empleados, 15, 512) ?>;
            const inputEmpleado = document.getElementById('empleadoInput');
            const results = document.getElementById('empleadoResults');
            const empleadoId = document.getElementById('empleado_id');
            const identidad = document.getElementById('identidad');
            const cargo = document.getElementById('cargo');
            const form = document.getElementById('incapacidadForm');
            const vistaDocumento = document.getElementById('vistaDocumento');
            const documentoInput = document.getElementById('documentoInput');
            const originalDoc = <?php echo json_encode($incapacidad->documento, 15, 512) ?>;

            // Mensajes personalizados
            const mensajes = {
                empleado: "Debe seleccionar un empleado válido.",
                fecha_inicio: "La fecha de inicio es obligatoria.",
                fecha_fin: "La fecha de fin es obligatoria.",
                motivo: "Debe ingresar el motivo de la incapacidad.",
                institucion_medica: "Debe indicar la institución médica.",
                documento: "Debe subir un documento válido."
            };

            // Función para mostrar mensaje de error debajo del campo
            function mostrarError(element, mensaje) {
                element.classList.add('is-invalid');
                let feedback = element.nextElementSibling;
                if(!feedback || !feedback.classList.contains('invalid-feedback')){
                    feedback = document.createElement('div');
                    feedback.classList.add('invalid-feedback');
                    element.parentNode.appendChild(feedback);
                }
                feedback.textContent = mensaje;
            }

            // Función para quitar error
            function quitarError(element) {
                element.classList.remove('is-invalid');
                let feedback = element.nextElementSibling;
                if(feedback && feedback.classList.contains('invalid-feedback')){
                    feedback.textContent = '';
                }
            }

            // Validar campos obligatorios
            // Validar campos obligatorios + lógica de fecha
            function validarCampos() {
                let valido = true;

                // Validar empleado
                const nombre = inputEmpleado.value.trim().toLowerCase();
                const empleadoValido = empleados.some(emp => (emp.nombre + ' ' + emp.apellido).toLowerCase() === nombre);
                if(!empleadoValido){
                    mostrarError(inputEmpleado, mensajes.empleado);
                    valido = false;
                } else {
                    quitarError(inputEmpleado);
                }

                // Campos obligatorios
                const campos = ['fecha_inicio', 'fecha_fin', 'motivo', 'institucion_medica'];
                campos.forEach(name => {
                    const campo = form.querySelector(`[name="${name}"]`);
                    if(campo && !campo.value.trim()){
                        mostrarError(campo, mensajes[name]);
                        valido = false;
                    } else if(campo) {
                        quitarError(campo);
                    }
                });

                // Validar fecha fin >= fecha inicio
                const fechaInicioInput = form.querySelector('[name="fecha_inicio"]');
                const fechaFinInput = form.querySelector('[name="fecha_fin"]');
                if(fechaInicioInput.value && fechaFinInput.value){
                    const fechaInicio = new Date(fechaInicioInput.value);
                    const fechaFin = new Date(fechaFinInput.value);
                    if(fechaFin < fechaInicio){
                        mostrarError(fechaFinInput, "La fecha fin no puede ser anterior a la fecha inicio.");
                        valido = false;
                    } else {
                        quitarError(fechaFinInput);
                    }
                }

                return valido;
            }

            // Vista previa al seleccionar archivo
            documentoInput.addEventListener('change', function(){
                const file = this.files[0];
                vistaDocumento.innerHTML = '';
                if(file){
                    const ext = file.name.split('.').pop().toLowerCase();
                    if(['jpg','jpeg','png'].includes(ext)){
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.classList.add('img-fluid','rounded');
                        img.style.maxHeight = '200px';
                        vistaDocumento.appendChild(img);
                    } else if(ext === 'pdf'){
                        const iframe = document.createElement('iframe');
                        iframe.src = URL.createObjectURL(file);
                        iframe.width = '100%';
                        iframe.height = '200px';
                        iframe.classList.add('border');
                        vistaDocumento.appendChild(iframe);
                    } else {
                        vistaDocumento.innerHTML = '<p class="text-muted">Formato no soportado</p>';
                    }
                } else {
                    // Restaurar original
                    if(originalDoc){
                        const ext = originalDoc.split('.').pop().toLowerCase();
                        if(['jpg','jpeg','png'].includes(ext)){
                            const img = document.createElement('img');
                            img.src = `/storage/${originalDoc}`;
                            img.classList.add('img-fluid','rounded');
                            img.style.maxHeight = '200px';
                            vistaDocumento.appendChild(img);
                        } else if(ext === 'pdf'){
                            const iframe = document.createElement('iframe');
                            iframe.src = `/storage/${originalDoc}`;
                            iframe.width = '100%';
                            iframe.height = '200px';
                            iframe.classList.add('border');
                            vistaDocumento.appendChild(iframe);
                        }
                    } else {
                        vistaDocumento.innerHTML = '<p class="text-muted">No hay documento cargado</p>';
                    }
                }
            });

            // Buscar empleados
            inputEmpleado.addEventListener('input', function() {
                const value = this.value.toLowerCase();
                results.innerHTML = '';
                if(!value.trim()){
                    empleadoId.value = '';
                    identidad.value = '';
                    cargo.value = '';
                    quitarError(inputEmpleado);
                    return;
                }
                const filtered = empleados.filter(emp => (emp.nombre + ' ' + emp.apellido).toLowerCase().includes(value));
                filtered.forEach(emp => {
                    const div = document.createElement('div');
                    div.classList.add('list-group-item','list-group-item-action');
                    div.style.cursor = 'pointer';
                    div.textContent = emp.nombre + ' ' + emp.apellido;
                    div.addEventListener('click', () => {
                        inputEmpleado.value = emp.nombre + ' ' + emp.apellido;
                        empleadoId.value = emp.id;
                        identidad.value = emp.identidad;
                        cargo.value = emp.categoria;
                        results.innerHTML = '';
                        quitarError(inputEmpleado);
                    });
                    results.appendChild(div);
                });
            });

            // Validación al enviar
            form.addEventListener('submit', function(e) {
                if(!validarCampos()){
                    e.preventDefault();
                }
            });

            // Botón Restablecer
            document.getElementById('btnRestablecer').addEventListener('click', function(e){
                e.preventDefault();

                // Restaurar valores originales
                form.querySelectorAll('[data-original]').forEach(el => {
                    el.value = el.dataset.original;
                    quitarError(el);
                });

                inputEmpleado.value = inputEmpleado.dataset.originalName;
                empleadoId.value = empleadoId.dataset.originalId;
                identidad.value = identidad.dataset.original;
                cargo.value = cargo.dataset.original;
                results.innerHTML = '';
                quitarError(inputEmpleado);

                // Restaurar vista previa
                vistaDocumento.innerHTML = '';
                if(originalDoc){
                    const ext = originalDoc.split('.').pop().toLowerCase();
                    if(['jpg','jpeg','png'].includes(ext)){
                        const img = document.createElement('img');
                        img.src = `/storage/${originalDoc}`;
                        img.classList.add('img-fluid','rounded');
                        img.style.maxHeight = '200px';
                        vistaDocumento.appendChild(img);
                    } else if(ext === 'pdf'){
                        const iframe = document.createElement('iframe');
                        iframe.src = `/storage/${originalDoc}`;
                        iframe.width = '100%';
                        iframe.height = '200px';
                        iframe.classList.add('border');
                        vistaDocumento.appendChild(iframe);
                    }
                } else {
                    vistaDocumento.innerHTML = '<p class="text-muted">No hay documento cargado</p>';
                }

                // Limpiar input de archivo
                documentoInput.value = '';
            });
        });

    </script>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/incapacidades/edit.blade.php ENDPATH**/ ?>