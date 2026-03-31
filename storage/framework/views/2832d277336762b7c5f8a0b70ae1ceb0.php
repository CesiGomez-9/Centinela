<?php $__env->startSection('content'); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-light p-5 rounded shadow-lg position-relative">

                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-building" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4" style="color: #09457f;">
                        <i class="bi bi-person-plus-fill me-2"></i> Editar una capacitación
                    </h3>

                    
                    <?php if(session('success')): ?>
                        <div class="alert alert-success text-center"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <form id="form-curso" action="<?php echo e(route('capacitaciones.update', $capacitacion->id)); ?>" method="POST" novalidate>
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-4">

                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre de la institución</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-book-fill"></i></span>
                                    <input type="text" name="nombre"
                                           class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('nombre', $capacitacion->nombre)); ?>"
                                           maxlength="50"
                                           onkeypress="return /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s.,]*$/.test(String.fromCharCode(event.charCode))"
                                           required>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Correo -->
                            <div class="col-md-6">
                                <label for="correo" class="form-label">Correo de la institución</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" name="correo"
                                           class="form-control <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('correo', $capacitacion->correo)); ?>"
                                           maxlength="50"
                                           required>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Contacto -->
                            <div class="col-md-6">
                                <label for="contacto" class="form-label">Nombre de contacto</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                                    <input type="text" name="contacto"
                                           class="form-control <?php $__errorArgs = ['contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('contacto', $capacitacion->contacto)); ?>"
                                           maxlength="50"
                                           required>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="telefono"
                                           class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('telefono', $capacitacion->telefono)); ?>"
                                           maxlength="8"
                                           pattern="[2389][0-9]{7}"
                                           required>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Modalidad -->
                            <div class="col-md-4">
                                <label for="modalidad" class="form-label">Modalidad</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                    <select name="modalidad" class="form-select <?php $__errorArgs = ['modalidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione una modalidad</option>
                                        <option value="Presencial" <?php echo e(old('modalidad', $capacitacion->modalidad)=='Presencial'?'selected':''); ?>>Presencial</option>
                                        <option value="Virtual" <?php echo e(old('modalidad', $capacitacion->modalidad)=='Virtual'?'selected':''); ?>>Virtual</option>
                                        <option value="Mixta" <?php echo e(old('modalidad', $capacitacion->modalidad)=='Mixta'?'selected':''); ?>>Mixta</option>
                                    </select>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['modalidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Nivel -->
                            <div class="col-md-4">
                                <label for="nivel" class="form-label">Nivel</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-bar-chart-fill"></i></span>
                                    <select name="nivel" class="form-select <?php $__errorArgs = ['nivel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Seleccione un nivel</option>
                                        <option value="Básico" <?php echo e(old('nivel', $capacitacion->nivel)=='Básico'?'selected':''); ?>>Básico</option>
                                        <option value="Intermedio" <?php echo e(old('nivel', $capacitacion->nivel)=='Intermedio'?'selected':''); ?>>Intermedio</option>
                                        <option value="Avanzado" <?php echo e(old('nivel', $capacitacion->nivel)=='Avanzado'?'selected':''); ?>>Avanzado</option>
                                    </select>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['nivel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Duración -->
                            <div class="col-md-4">
                                <label for="duracion" class="form-label">Duración (días)</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                                    <input type="number" name="duracion"
                                           class="form-control <?php $__errorArgs = ['duracion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('duracion', $capacitacion->duracion)); ?>"
                                           min="1" max="99"
                                           required>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['duracion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Fecha de inicio -->
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
                                    <input type="date" name="fecha_inicio"
                                           class="form-control <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('fecha_inicio', $capacitacion->fecha_inicio->format('Y-m-d'))); ?>"
                                           required>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['fecha_inicio'];
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
                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-calendar-check-fill"></i></span>
                                    <input type="date" name="fecha_fin"
                                           class="form-control <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           value="<?php echo e(old('fecha_fin', $capacitacion->fecha_fin->format('Y-m-d'))); ?>"
                                           required>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['fecha_fin'];
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
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <textarea name="descripcion" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="250" required><?php echo e(old('descripcion', $capacitacion->descripcion)); ?></textarea>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-6">
                                <label for="direccion" class="form-label">Dirección</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                    <textarea name="direccion" class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="250"><?php echo e(old('direccion', $capacitacion->direccion)); ?></textarea>
                                    <div class="invalid-feedback"><?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                </div>
                            </div>

                        </div>

                        <div class="text-center mt-5 d-flex justify-content-center gap-3">
                            <a href="<?php echo e(route('capacitaciones.index')); ?>" class="btn btn-danger"><i class="bi bi-x-circle me-2"></i> Cancelar</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i> Guardar cambios</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputDuracion = document.querySelector('input[name="duracion"]');
            const inputFechaInicio = document.querySelector('input[name="fecha_inicio"]');
            const inputFechaFin = document.querySelector('input[name="fecha_fin"]');

            // --- FUNCIONES DE CONCORDANCIA ---
            function actualizarFechaFin() {
                const inicio = inputFechaInicio.value;
                const dias = parseInt(inputDuracion.value);

                if (inicio && !isNaN(dias) && dias > 0) {
                    // Calcula fecha_fin visual según inicio + duración
                    const fecha = new Date(inicio + 'T00:00:00');
                    fecha.setDate(fecha.getDate() + (dias - 1));
                    inputFechaFin.value = fecha.toISOString().split('T')[0];

                    // Ajusta mínimo de fecha_fin visualmente
                    inputFechaFin.min = inicio;
                }
            }

            function actualizarDuracion() {
                const inicioStr = inputFechaInicio.value;
                const finStr = inputFechaFin.value;

                if (inicioStr && finStr) {
                    const inicio = new Date(inicioStr + 'T00:00:00');
                    const fin = new Date(finStr + 'T00:00:00');

                    // Calcula diferencia en días + 1
                    const dias = Math.floor((fin - inicio) / (1000 * 60 * 60 * 24)) + 1;
                    inputDuracion.value = dias > 0 ? dias : 1;
                }
            }

            // --- EVENTOS ---
            inputDuracion.addEventListener('input', actualizarFechaFin);
            inputFechaInicio.addEventListener('change', actualizarFechaFin);
            inputFechaFin.addEventListener('change', actualizarDuracion);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/capacitaciones/edit.blade.php ENDPATH**/ ?>