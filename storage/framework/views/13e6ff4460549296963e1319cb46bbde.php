<?php $__env->startSection('content'); ?>

    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }
        .form-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>




    <style>
        textarea.auto-expand {
            overflow-y: hidden;
            resize: none;
            min-height: 80px; /* Puedes ajustar este valor */
        }

    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-light p-5 rounded shadow-lg position-relative">

                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-exclamation-triangle" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4" style="color: #09457f;">
                        <i class="bi bi-file-earmark-text-fill me-2"></i> Registrar una incidencia
                    </h3>

                    
                    <form action="<?php echo e(route('incidencias.store')); ?>" method="POST" id="form-incidencia" novalidate>
                        <?php echo csrf_field(); ?>

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label for="clienteInput" class="form-label">Cliente afectado</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>

                                    <input type="text"
                                           id="clienteInput"
                                           name="cliente_nombre"
                                           class="form-control <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Buscar cliente"
                                           autocomplete="off"
                                           value="<?php echo e(old('cliente_nombre', $clienteSeleccionado ?? '')); ?>"
                                           required>

                                    <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo e(old('cliente_id')); ?>">
                                </div>

                                <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <div id="clienteResults" class="list-group mt-1" style="max-height:200px; overflow-y:auto;"></div>
                            </div>





                            <!-- Tipo -->
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo de incidencia</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                    <input type="text" id="tipo" name="tipo"
                                           class="form-control <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('tipo')); ?>" maxlength="100"
                                           onkeypress="soloLetras(event)"
                                           oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                                           onkeydown="bloquearEspacioAlInicio(event, this)"
                                           oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                           required>
                                </div>
                                <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>


                            <!-- Agentes involucrados -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agentes involucrados</label>

                                <div class="card">
                                    <div class="card-body" style="max-height: 200px; overflow-x: auto; overflow-y: hidden; white-space: nowrap;">
                                        <div style="display: flex; gap: 1rem;">
                                            <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(in_array($empleado->categoria, ['Tecnico', 'Vigilancia'])): ?>
                                                    <div class="form-check" style="flex: 0 0 auto; white-space: normal;">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               name="agente_id[]"
                                                               value="<?php echo e($empleado->id); ?>"
                                                               id="agente_<?php echo e($empleado->id); ?>"
                                                            <?php echo e((is_array(old('agente_id')) && in_array($empleado->id, old('agente_id'))) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="agente_<?php echo e($empleado->id); ?>">
                                                            <?php echo e($empleado->nombre); ?>  (<?php echo e(ucfirst($empleado->categoria)); ?>)
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>

                                <?php $__errorArgs = ['agente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>





                            <div class="col-md-6">
                                <label for="reportadoPorInput" class="form-label">Reportado por</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill-check"></i></span>

                                    <input type="text"
                                           id="reportadoPorInput"
                                           name="reportado_por_nombre"
                                           class="form-control <?php $__errorArgs = ['reportado_por'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Buscar empleado"
                                           autocomplete="off"
                                           value="<?php echo e(old('reportado_por_nombre', $empleadoSeleccionado ?? '')); ?>"
                                           required>

                                    <input type="hidden" name="reportado_por" id="reportado_por" value="<?php echo e(old('reportado_por')); ?>">
                                </div>

                                <?php $__errorArgs = ['reportado_por'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <div id="reportadoPorResults" class="list-group mt-1" style="max-height:200px; overflow-y:auto;"></div>
                            </div>




                            <!-- Fecha -->
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" id="fecha" name="fecha"
                                           class="form-control <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('fecha')); ?>" required>
                                </div>
                                <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-clipboard-check-fill"></i></span>
                                    <select id="estado" name="estado"
                                            class="form-select <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="en proceso" <?php echo e(old('estado') == 'en proceso' ? 'selected' : ''); ?>>En proceso</option>
                                        <option value="resuelta" <?php echo e(old('estado') == 'resuelta' ? 'selected' : ''); ?>>Resuelta</option>
                                        <option value="cerrada" <?php echo e(old('estado') == 'cerrada' ? 'selected' : ''); ?>>Cerrada</option>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>


                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea id="descripcion"
                                          name="descripcion"
                                          class="form-control auto-expand <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          maxlength="250"
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this); "
                                          oninput="this.style.height='';this.style.height=this.scrollHeight + 'px';"
                                          required><?php echo e(old('descripcion')); ?></textarea>
                            </div>
                            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>





                            <!-- Ubicación -->
                            <div class="col-md-6">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                    <textarea id="ubicacion"
                                              name="ubicacion"
                                              class="form-control auto-expand <?php $__errorArgs = ['ubicacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              maxlength="150"
                                              oninput="this.style.height='';this.style.height=this.scrollHeight + 'px';"
                                              required><?php echo e(old('ubicacion')); ?></textarea>
                                </div>
                                <?php $__errorArgs = ['ubicacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                        </div>





                        <div class="text-center mt-5 d-flex justify-content-center gap-3">
                            <!-- Botón Cancelar -->
                            <a href="<?php echo e(route('incidencias.index')); ?>" class="btn btn-danger">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>
                            <!-- Botón Limpiar -->
                            <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">
                                <i class="bi bi-eraser-fill me-2"></i> Limpiar
                            </button>

                            <!-- Botón Guardar -->
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save-fill me-2"></i> Guardar
                            </button>

                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>


            // Auto expand para textareas
            const textareas = document.querySelectorAll("textarea.auto-expand");
            textareas.forEach(el => {
                el.style.height = '';
                el.style.height = el.scrollHeight + 'px';

        });


    </script>

    <script>


            const clientes = <?php echo json_encode($clientes->map(fn($c) => ['id' => $c->id, 'nombre' => $c->nombre]), 512) ?>;

            const clienteInput = document.getElementById('clienteInput');
            const clienteId = document.getElementById('cliente_id');
            const clienteResults = document.getElementById('clienteResults');

            clienteInput.addEventListener('input', () => {
            const query = clienteInput.value.toLowerCase().trim();
            clienteResults.innerHTML = '';
            clienteId.value = ''; // Reset al ID si cambia el texto

            if (!query) return;

            const matches = clientes.filter(c => c.nombre.toLowerCase().includes(query));

            if (matches.length === 0) {
            clienteResults.innerHTML = '<div class="list-group-item disabled">No se encontraron resultados</div>';
            return;
        }

            matches.forEach(cliente => {
            const item = document.createElement('div');
            item.classList.add('list-group-item', 'list-group-item-action');
            item.textContent = cliente.nombre;
            item.style.cursor = 'pointer';

            item.addEventListener('click', () => {
            clienteInput.value = cliente.nombre;
            clienteId.value = cliente.id;
            clienteResults.innerHTML = '';
        });

            clienteResults.appendChild(item);
        });
        });

            clienteInput.addEventListener('blur', () => {
            setTimeout(() => clienteResults.innerHTML = '', 200); // Espera para permitir click
        });




                const empleadosAdministracion = <?php echo json_encode(
        $empleados->filter(fn($e) => $e->categoria === 'Administracion')
                  ->map(fn($e) => [
                      'id' => $e->id, 'nombre' => trim($e->nombre . ' ' . $e->apellido)
                  ])
                  ->values(), 512) ?>;
                console.log('Empleados admins:', empleadosAdministracion);

                const reportadoInput = document.getElementById('reportadoPorInput');
                const reportadoId = document.getElementById('reportado_por');
                const reportadoResults = document.getElementById('reportadoPorResults');

                reportadoInput.addEventListener('input', () => {
                const query = reportadoInput.value.toLowerCase().trim();
                console.log('Query:', query);

                reportadoResults.innerHTML = '';
                reportadoId.value = '';

                if (!query) {
                return;
            }

                const matches = empleadosAdministracion.filter(e =>
                e.nombre.toLowerCase().includes(query)
                );
                console.log('Matches:', matches);

                if (matches.length === 0) {
                reportadoResults.innerHTML = '<div class="list-group-item disabled">No se encontraron resultados</div>';
                return;
            }

                matches.forEach(empleado => {
                const item = document.createElement('div');
                item.classList.add('list-group-item', 'list-group-item-action');
                item.textContent = empleado.nombre;
                item.style.cursor = 'pointer';

                item.addEventListener('click', () => {
                reportadoInput.value = empleado.nombre;
                reportadoId.value = empleado.id;
                reportadoResults.innerHTML = '';
                console.log('Seleccionado:', empleado);
            });

                reportadoResults.appendChild(item);
            });
            });

                reportadoInput.addEventListener('blur', () => {
                setTimeout(() => {
                    reportadoResults.innerHTML = '';
                }, 200);
            });





    function validarSoloLetras(input) {
            input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
            if (input.value.length > 50) {
                input.value = input.value.substring(0, 50);
            }



        }

        function soloLetras(e) {
            const key = e.key;
            const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]$/;
            if (!regex.test(key) && !['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'].includes(key)) {
                e.preventDefault();
            }



        }

        function bloquearEspacioAlInicio(e, input) {
            if (e.key === ' ' && input.selectionStart === 0) {
                e.preventDefault();
            }
        }

        function limpiarFormulario() {
            const form = document.getElementById('form-incidencia');
            if (!form) return;

            // Limpiar inputs y textarea
            form.querySelectorAll('input[type="text"], input[type="date"], textarea').forEach(input => {
                input.value = '';
                input.classList.remove('is-invalid', 'is-valid');
            });

            // Limpiar selects (TomSelect o normales)
            form.querySelectorAll('select').forEach(select => {
                if (select.tomselect) {
                    select.tomselect.clear();
                    select.tomselect.setTextboxValue('');
                } else {
                    select.selectedIndex = 0;
                }

                select.classList.remove('is-invalid', 'is-valid');

                const tsWrapper = select.closest('.ts-wrapper');
                if (tsWrapper) {
                    tsWrapper.classList.remove('is-invalid', 'is-valid', 'was-validated');
                }

                const tsControl = tsWrapper?.querySelector('.ts-control');
                if (tsControl) {
                    tsControl.classList.remove('is-invalid', 'is-valid');
                }
            });

            // Limpiar mensajes de error
            form.querySelectorAll('.invalid-feedback, .text-danger').forEach(el => {
                el.textContent = '';
                el.style.display = 'none';
                el.classList.remove('d-block');
            });

            form.classList.remove('was-validated');

            // Limpiar checkboxes y radios
            form.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => {
                input.checked = false;
                input.classList.remove('is-invalid', 'is-valid');
            });

            // Foco en primer campo
            const primerCampo = form.querySelector('input, select, textarea');
            if (primerCampo) primerCampo.focus();
        }


    </script>






</body>
</html>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/incidencias/formulario.blade.php ENDPATH**/ ?>