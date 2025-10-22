<?php $__env->startSection('content'); ?>


    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Incidencia</title>
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

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-light p-5 rounded shadow-lg position-relative">

                <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                    <i class="bi bi-building" style="font-size: 4rem;"></i>
                </div>

                <h3 class="text-center mb-4" style="color: #09457f;">
                    <i class="bi bi-person-plus-fill me-2"></i> Editar datos de la incidencia
                </h3>

                <style>
                    .invalid-tooltip {
                        background-color: transparent !important;
                        border: 1px solid #dc3545 !important;
                        color: #dc3545 !important;
                        box-shadow: none !important;
                        padding: 0.5rem 1rem !important;
                        font-size: 0.9rem !important;
                        top: 100% !important;
                        margin-top: 0.25rem !important;
                        z-index: 10 !important;
                        white-space: normal !important;
                    }
                </style>


                <form action="<?php echo e(route('incidencias.update', $incidencia->id)); ?>" method="POST" id="form-incidencia" novalidate>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row g-4">

                        
                        <div class="col-md-6">
                            <label for="clienteInput" class="form-label">Cliente afectado</label>
                            <div class="input-group has-validation">
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
                                       value="<?php echo e(old('cliente_nombre', $incidencia->cliente->nombre ?? '')); ?>"
                                       required>
                                <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo e(old('cliente_id', $incidencia->cliente_id ?? '')); ?>">
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


                        
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo de incidencia</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                <select id="tipo" name="tipo" class="form-select <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Seleccione un tipo</option>
                                    <?php $__currentLoopData = [
                                        "accidentes laborales",
                                        "conflictos con clientes",
                                        "errores en la instalacion",
                                        "fallas tecnicas",
                                        "falla o retraso del personal",
                                        "incidentes de seguridad",
                                        "incumplimiento de protocolos",
                                        "otros"
                                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($dep); ?>" <?php echo e(old('tipo', $incidencia->tipo) == $dep ? 'selected' : ''); ?>><?php echo e($dep); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>


                        <!-- Agentes involucrados -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Empleados involucrados</label>

                            <div class="card">
                                <div class="card-body" style="max-height: 200px; overflow-y: auto; overflow-x: hidden;">
                                    <div>
                                        <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(in_array($empleado->categoria, ['Tecnico', 'Vigilancia'])): ?>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           name="agente_id[]"
                                                           value="<?php echo e($empleado->id); ?>"
                                                           id="agente_<?php echo e($empleado->id); ?>"
                                                        <?php echo e((
                                                                (is_array(old('agente_id')) && in_array($empleado->id, old('agente_id'))) ||
                                                                (!old('agente_id') && isset($incidencia) && $incidencia->agentes->contains('id', $empleado->id))
                                                            ) ? 'checked' : ''); ?>>
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
                            <div class="input-group has-validation">
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
                                       value="<?php echo e(old('reportado_por_nombre', $incidencia->reportadoPorEmpleado->nombre ?? '')); ?>"
                                       required>

                                
                                <input type="hidden"
                                       name="reportado_por"
                                       id="reportado_por"
                                       value="<?php echo e(old('reportado_por', $incidencia->reportado_por ?? '')); ?>">
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


                        
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <input type="date" id="fecha" name="fecha" class="form-control <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('fecha', $incidencia->fecha)); ?>" required>

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

                        
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clipboard-check-fill"></i></span>
                                <select name="estado" class="form-select">
                                    <option value="en proceso" <?php echo e($incidencia->estado == 'en proceso' ? 'selected' : ''); ?>>En proceso</option>
                                    <option value="resuelta" <?php echo e($incidencia->estado == 'resuelta' ? 'selected' : ''); ?>>Resuelta</option>
                                    <option value="cerrada" <?php echo e($incidencia->estado == 'cerrada' ? 'selected' : ''); ?>>Cerrada</option>
                                </select>
                            </div>
                        </div>


                        
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group has-validation">
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
                                          oninput="eliminarEspaciosIniciales(this); this.style.height=''; this.style.height=this.scrollHeight + 'px';"
                                          required><?php echo e(old('descripcion', $incidencia->descripcion ?? '')); ?></textarea>
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

                        
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <div class="input-group has-validation">
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
                                          onkeydown="bloquearEspacioAlInicio(event, this)"
                                          oninput="eliminarEspaciosIniciales(this); this.style.height=''; this.style.height=this.scrollHeight + 'px';"
                                          required><?php echo e(old('ubicacion', $incidencia->ubicacion ?? '')); ?></textarea>
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
                        <a href="<?php echo e(route('incidencias.index')); ?>" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <a href="<?php echo e(route('incidencias.edit', $incidencia->id)); ?>"
                           class="btn btn-warning">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                        </a>

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
    function autoExpand(el) {
        // Reinicia la altura
        el.style.height = "auto";
        // Asegura que se expanda correctamente según el scrollHeight
        el.style.height = (el.scrollHeight) + "px";
    }

    document.addEventListener("DOMContentLoaded", function () {
        const direccion = document.getElementById("direccion");
        if (direccion) {
            autoExpand(direccion); // ajusta si ya tiene texto
            direccion.addEventListener("input", function () {
                autoExpand(direccion);
            });
        }
    });
</script>


<script>

    document.getElementById('clienteInput').addEventListener('input', function () {
        if (this.value.trim() === '') {
            document.getElementById('cliente_id').value = '';
        }
    });

    document.getElementById('reportadoPorInput').addEventListener('input', function () {
        document.getElementById('reportado_por').value = '';
    });
    function soloLetras(e) {
        const key = e.key;
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]$/.test(key) && !['Backspace','Tab','ArrowLeft','ArrowRight','Delete'].includes(key)) {
            e.preventDefault();
        }
    }

    function soloNumeros(e) {
        const key = e.key;
        if (!/^[0-9]$/.test(key) && !['Backspace','Tab','ArrowLeft','ArrowRight','Delete'].includes(key)) {
            e.preventDefault();
        }
    }

    function bloquearEspacioAlInicio(e, input) {
        if (e.key === ' ' && input.selectionStart === 0) {
            e.preventDefault();
        }
    }

    function eliminarEspaciosIniciales(input) {
        input.value = input.value.replace(/^\s+/, '');
    }
</script>




<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/incidencias/edit.blade.php ENDPATH**/ ?>