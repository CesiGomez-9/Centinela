<?php $__env->startSection('content'); ?>

    <style>
        .invalid-feedback { display: block; }
    </style>

    <body style="background-color: #e6f0ff;">
    <div class="container bg-white p-5 rounded shadow mt-5 mb-5" style="max-width: 950px;">
        <div class="d-flex justify-content-center mb-4">
            <h3 class="mb-0 text-center" style="color:#09457f;">
                <i class="bi bi-journal-text me-2"></i>Editar memorandum
            </h3>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <form id="memorandumForm" action="<?php echo e(route('memorandos.update', $memorando->id)); ?>" method="POST" enctype="multipart/form-data" novalidate>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row g-3">

                
                <div class="col-md-6">
                    <label for="destinatarioInput" class="form-label fw-bold">Empleado:</label>
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
                               value="<?php echo e(old('destinatario_nombre', $memorando->destinatario ? $memorando->destinatario->nombre.' '.$memorando->destinatario->apellido : '')); ?>"
                               data-original="<?php echo e(old('destinatario_nombre', $memorando->destinatario ? $memorando->destinatario->nombre.' '.$memorando->destinatario->apellido : '')); ?>">
                        <input type="hidden" name="destinatario_id" id="destinatario_id"
                               value="<?php echo e(old('destinatario_id', $memorando->destinatario_id)); ?>"
                               data-original="<?php echo e(old('destinatario_id', $memorando->destinatario_id)); ?>">
                    </div>
                    <div class="invalid-feedback d-block"><?php $__errorArgs = ['destinatario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    <div id="destinatarioResults" class="list-group" style="max-height:200px; overflow-y:auto;"></div>
                </div>

                
                <div class="col-md-6">
                    <label for="autorInput" class="form-label fw-bold">Autor:</label>
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
                               value="<?php echo e(old('autor_nombre', $memorando->autor ? $memorando->autor->nombre.' '.$memorando->autor->apellido : '')); ?>"
                               data-original="<?php echo e(old('autor_nombre', $memorando->autor ? $memorando->autor->nombre.' '.$memorando->autor->apellido : '')); ?>">
                        <input type="hidden" name="autor_id" id="autor_id"
                               value="<?php echo e(old('autor_id', $memorando->autor_id)); ?>"
                               data-original="<?php echo e(old('autor_id', $memorando->autor_id)); ?>">
                    </div>
                    <div class="invalid-feedback d-block"><?php $__errorArgs = ['autor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
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
                               value="<?php echo e(old('fecha', $memorando->fecha)); ?>"
                               data-original="<?php echo e(old('fecha', $memorando->fecha)); ?>">
                        <div class="invalid-feedback"><?php $__errorArgs = ['fecha'];
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
unset($__errorArgs, $__bag); ?>" required
                                data-original="<?php echo e(old('tipo', $memorando->tipo)); ?>">
                            <option value="">Seleccione un tipo</option>
                            <option value="leve" <?php echo e(old('tipo', $memorando->tipo)=='leve'?'selected':''); ?>>Leve</option>
                            <option value="media" <?php echo e(old('tipo', $memorando->tipo)=='media'?'selected':''); ?>>Media</option>
                            <option value="grave" <?php echo e(old('tipo', $memorando->tipo)=='grave'?'selected':''); ?>>Grave</option>
                        </select>
                        <div class="invalid-feedback"><?php $__errorArgs = ['tipo'];
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
                               value="<?php echo e(old('titulo', $memorando->titulo)); ?>"
                               data-original="<?php echo e(old('titulo', $memorando->titulo)); ?>">
                        <div class="invalid-feedback"><?php $__errorArgs = ['titulo'];
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
                                  style="overflow:hidden; resize:none;"
                                  data-original="<?php echo e(old('contenido', $memorando->contenido)); ?>"><?php echo e(old('contenido', $memorando->contenido)); ?></textarea>
                        <div class="invalid-feedback"><?php $__errorArgs = ['contenido'];
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
                        <span class="input-group-text"><i class="bi bi-hammer"></i></span>
                        <textarea id="sancion" name="sancion"
                                  class="form-control <?php $__errorArgs = ['sancion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  style="overflow:hidden; resize:none;"
                                  data-original="<?php echo e(old('sancion', $memorando->sancion)); ?>"><?php echo e(old('sancion', $memorando->sancion)); ?></textarea>
                    </div>
                    <div class="invalid-feedback"><?php $__errorArgs = ['sancion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                </div>

                
                <div class="col-md-12">
                    <label class="form-label fw-bold">Adjunto (opcional):</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-paperclip"></i></span>
                        <input type="file" name="adjunto" id="adjuntoInput"
                               class="form-control <?php $__errorArgs = ['adjunto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               accept=".pdf,.doc,.docx,.jpg,.png">
                        <div class="invalid-feedback"><?php $__errorArgs = ['adjunto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    </div>
                    <small id="adjuntoOriginal">
                        <?php if($memorando->adjunto): ?>
                            Archivo actual: <a href="<?php echo e(asset('storage/'.$memorando->adjunto)); ?>" target="_blank"><?php echo e($memorando->adjunto); ?></a>
                        <?php else: ?>
                            No se eligió ningún archivo
                        <?php endif; ?>
                    </small>
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
                                  style="overflow:hidden; resize:none;"
                                  data-original="<?php echo e(old('observaciones', $memorando->observaciones)); ?>"><?php echo e(old('observaciones', $memorando->observaciones)); ?></textarea>
                        <div class="invalid-feedback"><?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                    </div>
                </div>

                
                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                    <a href="<?php echo e(route('memorandos.index')); ?>" class="btn btn-danger">
                        <i class="bi bi-x-circle me-2"></i> Cancelar
                    </a>

                    <button type="button" id="btnRestablecer" class="btn btn-warning me-2">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save-fill me-2"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('memorandumForm');
            const resetBtn = document.getElementById('btnRestablecer');

            function autoResize(textarea){
                textarea.style.height='auto';
                textarea.style.height = textarea.scrollHeight+'px';
            }

            ['contenido','sancion','observaciones'].forEach(id=>{
                const campo = document.getElementById(id);
                if(campo){
                    campo.addEventListener('input',()=>autoResize(campo));
                    autoResize(campo);
                }
            });

            // --- Guardar valores reales de la BD como "saved" ---
            const memorando = <?php echo json_encode($memorando, 15, 512) ?>;

            form.querySelectorAll('input, select, textarea').forEach(el=>{
                if(el.type==='file' || el.name==='_token' || el.name==='_method') return;

                // original = valor visible (puede venir de old())
                el.dataset.original = el.value ?? '';

                // saved = valor real de la BD
                if(memorando.hasOwnProperty(el.name)){
                    el.dataset.saved = memorando[el.name] ?? '';
                } else {
                    el.dataset.saved = el.value ?? '';
                }

                if(el.tagName.toLowerCase()==='textarea') autoResize(el);
            });

            // Hidden de destinatario y autor
            const destInput = document.getElementById('destinatarioInput');
            const destHidden = document.getElementById('destinatario_id');
            destInput.dataset.saved = '<?php echo e($memorando->destinatario ? $memorando->destinatario->nombre." ".$memorando->destinatario->apellido : ""); ?>';
            destHidden.dataset.saved = '<?php echo e($memorando->destinatario_id); ?>';

            const autorInput = document.getElementById('autorInput');
            const autorHidden = document.getElementById('autor_id');
            autorInput.dataset.saved = '<?php echo e($memorando->autor ? $memorando->autor->nombre." ".$memorando->autor->apellido : ""); ?>';
            autorHidden.dataset.saved = '<?php echo e($memorando->autor_id); ?>';

            const adjuntoInput = document.getElementById('adjuntoInput');
            const adjuntoOriginal = document.getElementById('adjuntoOriginal');

            // --- Botón Restablecer ---
            resetBtn.addEventListener('click', function(e){
                e.preventDefault();

                form.querySelectorAll('.is-invalid').forEach(el=>el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(div=>div.textContent='');

                // Restaurar todos los campos a "saved"
                form.querySelectorAll('input, select, textarea').forEach(el=>{
                    if(el.type==='file' || el.name==='_token' || el.name==='_method') return;
                    el.value = el.dataset.saved ?? '';
                    if(el.tagName.toLowerCase()==='textarea') autoResize(el);
                });

                // Restaurar hidden y autocomplete
                destInput.value = destInput.dataset.saved ?? '';
                destHidden.value = destHidden.dataset.saved ?? '';
                autorInput.value = autorInput.dataset.saved ?? '';
                autorHidden.value = autorHidden.dataset.saved ?? '';

                // Limpiar resultados de autocomplete
                document.getElementById('destinatarioResults').innerHTML = '';
                document.getElementById('autorResults').innerHTML = '';

                // Limpiar file input
                const fileInput = form.querySelector('input[type="file"]');
                if(fileInput) fileInput.value = '';

                // Restaurar texto del archivo original
                if(adjuntoOriginal){
                    adjuntoOriginal.innerHTML = memorando.adjunto
                        ? `Archivo actual: <a href="/storage/${memorando.adjunto}" target="_blank">${memorando.adjunto}</a>`
                        : 'No se eligió ningún archivo';
                }
            });

// --- Mostrar nombre del archivo seleccionado ---
            if(adjuntoInput){
                adjuntoInput.addEventListener('change', function() {
                    if(this.files.length > 0){
                        adjuntoOriginal.innerHTML = `Archivo seleccionado: ${this.files[0].name}`;
                    } else {
                        adjuntoOriginal.innerHTML = memorando.adjunto
                            ? `Archivo actual: <a href="/storage/${memorando.adjunto}" target="_blank">${memorando.adjunto}</a>`
                            : 'No se eligió ningún archivo';
                    }
                });
            }

        });
    </script>






    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/memorandos/edit.blade.php ENDPATH**/ ?>