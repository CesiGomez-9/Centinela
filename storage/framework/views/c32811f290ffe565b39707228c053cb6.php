<?php $__env->startSection('content'); ?>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width:900px;">
        <div class="card shadow p-4 bg-white position-relative">
            <i class="bi bi-file-earmark-text position-absolute top-0 end-0 p-3 text-secondary opacity-25" style="font-size:4rem;"></i>

            <h3 class="text-center mb-4" style="color:#09457f;">
                <i class="bi bi-journal-text me-2"></i>Crear un nuevo memorandum
            </h3>

            <?php if(session('success')): ?>
                <div class="alert alert-success">¡Memorandum guardado correctamente!</div>
            <?php endif; ?>

            <form action="<?php echo e(route('memorandos.store')); ?>" method="POST" enctype="multipart/form-data" novalidate>
                <?php echo csrf_field(); ?>
                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="destinatarioInput" class="form-label fw-bold">Empleado Sancionado:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   id="destinatarioInput"
                                   name="destinatario_nombre"
                                   class="form-control <?php $__errorArgs = ['destinatario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Buscar empleado..."
                                   autocomplete="off"
                                   value="<?php echo e(old('destinatario_nombre', $destinatarioSeleccionado ?? '')); ?>">
                            <input type="hidden" name="destinatario_id" id="destinatario_id" value="<?php echo e(old('destinatario_id')); ?>">
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['destinatario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                        <div id="destinatarioResults" class="list-group" style="max-height:200px; overflow-y:auto;"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="autorInput" class="form-label fw-bold">Creador del memorandum:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   id="autorInput"
                                   name="autor_nombre"
                                   class="form-control <?php $__errorArgs = ['autor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Buscar empleado..."
                                   autocomplete="off"
                                   value="<?php echo e(old('autor_nombre', $autorSeleccionado ?? '')); ?>">
                            <input type="hidden" name="autor_id" id="autor_id" value="<?php echo e(old('autor_id')); ?>">
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['autor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>
                        <div id="autorResults" class="list-group" style="max-height:200px; overflow-y:auto;"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Fecha de la incidencia:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-date-fill"></i></span>
                            <input type="date" id="fecha" name="fecha" class="form-control <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('fecha', date('Y-m-d'))); ?>">
                            <div class="invalid-feedback d-block" id="fechaError"><?php $__errorArgs = ['fecha'];
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
                        <label class="form-label fw-bold">Tipo:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-exclamation-triangle-fill"></i></span>
                            <select name="tipo" id="tipo" class="form-select <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="leve" <?php echo e(old('tipo') == 'leve' ? 'selected' : ''); ?>>Leve</option>
                                <option value="media" <?php echo e(old('tipo') == 'media' ? 'selected' : ''); ?>>Media</option>
                                <option value="grave" <?php echo e(old('tipo') == 'grave' ? 'selected' : ''); ?>>Grave</option>
                            </select>
                            <div class="invalid-feedback d-block" id="tipoError"><?php $__errorArgs = ['tipo'];
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
                        <label class="form-label fw-bold">Asunto:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                            <input type="text" id="titulo" name="titulo"
                                   class="form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('titulo')); ?>">
                            <div class="invalid-feedback d-block" id="tituloError"><?php $__errorArgs = ['titulo'];
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
                        <label class="form-label fw-bold">Motivo del memorandum:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span>
                            <textarea id="contenido" name="contenido"
                                      class="form-control <?php $__errorArgs = ['contenido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      style="overflow:hidden; resize:none;"><?php echo e(old('contenido')); ?></textarea>
                            <div class="invalid-feedback d-block" id="contenidoError"><?php $__errorArgs = ['contenido'];
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
                        <label class="form-label fw-bold">Sanción:</label>
                        <div class="input-group">
                            <span class="input-group-text text-dark"><i class="bi bi-hammer"></i></span>
                            <textarea id="sancion" name="sancion"
                                      class="form-control <?php $__errorArgs = ['sancion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      style="overflow:hidden; resize:none;"><?php echo e(old('sancion')); ?></textarea>
                        </div>
                        <div class="invalid-feedback d-block" id="sancionError">
                            <?php $__errorArgs = ['sancion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="adjunto" class="form-label fw-bold">
                            <i class="bi bi-paperclip me-2"></i>Adjunto (opcional):
                        </label>
                        <input type="file" class="form-control" id="adjunto" name="adjunto" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Observaciones (opcional):</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-chat-left-text-fill"></i></span>
                            <textarea id="observaciones" name="observaciones" rows="2"
                                      class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      style="overflow:hidden; resize:none;"><?php echo e(old('observaciones')); ?></textarea>
                            <div class="invalid-feedback d-block"><?php $__errorArgs = ['observaciones'];
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
                        <a href="<?php echo e(route('memorandos.index')); ?>" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="reset" class="btn btn-warning me-2" id="btnLimpiar">
                            <i class="bi bi-eraser-fill me-2"></i>Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i>Guardar</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <script>
        function limitarCaracteres(campoId, maxCaracteres) {
            const campo = document.getElementById(campoId);
            campo.addEventListener('input', function() {
                if (campo.value.length > maxCaracteres) {
                    campo.value = campo.value.slice(0, maxCaracteres);
                }
            });
        }
        limitarCaracteres("titulo", 100);
        limitarCaracteres("contenido", 250);
        limitarCaracteres("sancion", 250);
        limitarCaracteres("observaciones", 250);

        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        ['contenido', 'sancion', 'observaciones'].forEach(id => {
            const campo = document.getElementById(id);
            if (campo) {
                campo.addEventListener('input', () => autoResize(campo));
                autoResize(campo);
            }
        });

        function getFechaLocal() {
            const hoy = new Date();
            const year = hoy.getFullYear();
            const month = String(hoy.getMonth() + 1).padStart(2, '0');
            const day = String(hoy.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        document.getElementById('btnLimpiar').addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            const alerta = document.querySelector('.alert');
            if (alerta) alerta.remove();

            document.getElementById('destinatarioInput').value = '';
            document.getElementById('autorInput').value = '';
            document.getElementById('destinatario_id').value = '';
            document.getElementById('autor_id').value = '';
            document.getElementById('destinatarioResults').innerHTML = '';
            document.getElementById('autorResults').innerHTML = '';
            document.getElementById('titulo').value = '';
            document.getElementById('contenido').value = '';
            document.getElementById('sancion').value = '';
            document.getElementById('observaciones').value = '';
            document.getElementById('tipo').selectedIndex = 0;

            document.getElementById('fecha').value = getFechaLocal();

            const adjuntoInput = document.querySelector('input[name="adjunto"]');
            adjuntoInput.value = '';
            sessionStorage.removeItem('archivoAdjunto');

            const label = adjuntoInput.nextElementSibling;
            if (label && label.classList.contains('archivo-nombre')) {
                label.remove();
            }

            ['contenido', 'sancion', 'observaciones'].forEach(id => {
                const campo = document.getElementById(id);
                if (campo) autoResize(campo);
            });
        });

        const fileInput = document.querySelector('input[name="adjunto"]');
        const storedFile = sessionStorage.getItem('archivoAdjunto');

        if (storedFile) {
            mostrarNombreArchivo(storedFile);
        }

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                const nombreArchivo = fileInput.files[0].name;
                sessionStorage.setItem('archivoAdjunto', nombreArchivo);
                mostrarNombreArchivo(nombreArchivo);
            } else {
                sessionStorage.removeItem('archivoAdjunto');
                mostrarNombreArchivo('No se eligió ningún archivo');
            }
        });

        function mostrarNombreArchivo(nombre) {
            const dataTransfer = new DataTransfer();
            const fakeFile = new File([""], nombre);
            dataTransfer.items.add(fakeFile);
            fileInput.files = dataTransfer.files;
        }

        function setupAutocomplete(inputId, resultsId, hiddenId, url, extraParams = {}) {
            const input = document.getElementById(inputId);
            const results = document.getElementById(resultsId);
            const hidden = document.getElementById(hiddenId);

            input.addEventListener('input', function () {
                const query = this.value.trim();
                hidden.value = '';
                if (!query) {
                    results.innerHTML = '';
                    return;
                }
                fetch(url + '?' + new URLSearchParams({ q: query, ...extraParams }))
                    .then(res => res.json())
                    .then(data => {
                        results.innerHTML = '';
                        if (data.length === 0) return;
                        data.forEach(emp => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.classList.add('list-group-item', 'list-group-item-action');
                            item.textContent = emp.nombre + ' ' + emp.apellido;
                            item.addEventListener('click', () => {
                                input.value = emp.nombre + ' ' + emp.apellido;
                                hidden.value = emp.id;
                                results.innerHTML = '';
                            });
                            results.appendChild(item);
                        });
                    });
            });
            document.addEventListener('click', function(e){
                if (!results.contains(e.target) && e.target !== input) {
                    results.innerHTML = '';
                }
            });
        }

        setupAutocomplete('destinatarioInput', 'destinatarioResults', 'destinatario_id', '<?php echo e(route("empleados.buscar")); ?>', { tipo: 'todos' });
        setupAutocomplete('autorInput', 'autorResults', 'autor_id', '<?php echo e(route("empleados.buscar")); ?>', { tipo: 'administracion' });
    </script>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/memorandos/create.blade.php ENDPATH**/ ?>