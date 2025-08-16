<?php $__env->startSection('content'); ?>
    <!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Proveedor</title>
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
                    <i class="bi bi-person-plus-fill me-2"></i> Editar los datos del proveedor
                </h3>

                <form action="<?php echo e(route('Proveedores.update', $proveedor->id)); ?>" method="POST" id="form-proveedor" novalidate>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row g-4">
                        
                        <div class="col-md-6">
                            <label for="nombreEmpresa" class="form-label">Nombre de la empresa</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="nombreEmpresa"
                                       class="form-control <?php $__errorArgs = ['nombreEmpresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('nombreEmpresa', $proveedor->nombreEmpresa)); ?>"
                                       maxlength="50" onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                                       required>
                                <?php $__errorArgs = ['nombreEmpresa'];
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

                        
                        <div class="col-md-6">
                            <label for="nombrerepresentante" class="form-label">Nombre del representante</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="nombrerepresentante"
                                       class="form-control <?php $__errorArgs = ['nombrerepresentante'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('nombrerepresentante', $proveedor->nombrerepresentante)); ?>"
                                       maxlength="50" onkeypress="soloLetras(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                                       required>
                                <?php $__errorArgs = ['nombrerepresentante'];
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



                        
                        <div class="col-md-6">
                            <label for="telefonodeempresa" class="form-label">Teléfono de la empresa</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" name="telefonodeempresa"
                                       class="form-control <?php $__errorArgs = ['telefonodeempresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('telefonodeempresa', $proveedor->telefonodeempresa)); ?>"
                                       maxlength="8" onkeypress="soloNumeros(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                <?php $__errorArgs = ['telefonodeempresa'];
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

                        
                        <div class="col-md-6">
                            <label for="correoempresa" class="form-label">Correo Electrónico</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="correoempresa"
                                       class="form-control <?php $__errorArgs = ['correoempresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('correoempresa', $proveedor->correoempresa)); ?>"
                                       maxlength="50"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this)"
                                       required>
                                <?php $__errorArgs = ['correoempresa'];
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

                        
                        <div class="col-md-6">
                            <label for="telefonoderepresentante" class="form-label">Teléfono del representante</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" name="telefonoderepresentante"
                                       class="form-control <?php $__errorArgs = ['telefonoderepresentante'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('telefonoderepresentante', $proveedor->telefonoderepresentante)); ?>"
                                       maxlength="8" onkeypress="soloNumeros(event)"
                                       onkeydown="bloquearEspacioAlInicio(event, this)"
                                       oninput="eliminarEspaciosIniciales(this); this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                                <?php $__errorArgs = ['telefonoderepresentante'];
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






                        
                        <div class="col-md-6">
                            <label for="categoriarubro" class="form-label">Categoría o rubro</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                <select name="categoriarubro" class="form-select <?php $__errorArgs = ['categoriarubro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php $__currentLoopData = [
                                        'Cámaras de seguridad',
                                        'Alarmas antirrobo',
                                        'Cerraduras inteligentes',
                                        'Sensores de movimiento',
                                        'Luces con sensor de movimiento',
                                        'Rejas o puertas de seguridad',
                                        'Sistema de monitoreo 24/7',
                                        'Otros'
                                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categoria); ?>" <?php echo e(old('categoriarubro', $proveedor->categoriarubro) == $categoria ? 'selected' : ''); ?>>
                                            <?php echo e($categoria); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['categoriarubro'];
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

                        
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>

                                <textarea
                                    name="direccion"
                                    class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    maxlength="250"
                                    style="height: 100px; resize: none; overflow: hidden;" 
                                    onkeydown="bloquearEspacioAlInicio(event, this)"
                                    oninput="eliminarEspaciosIniciales(this)"><?php echo e(old('direccion', $proveedor->direccion)); ?></textarea>

                                <?php $__errorArgs = ['direccion'];
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


                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <select name="departamento" class="form-select <?php $__errorArgs = ['departamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Seleccione un departamento</option>
                                    <option value="Atlántida" <?php echo e((old('departamento', $proveedor->departamento) == 'Atlántida') ? 'selected' : ''); ?>>Atlántida</option>
                                    <option value="Choluteca" <?php echo e((old('departamento', $proveedor->departamento) == 'Choluteca') ? 'selected' : ''); ?>>Choluteca</option>
                                    <option value="Colón" <?php echo e((old('departamento', $proveedor->departamento) == 'Colón') ? 'selected' : ''); ?>>Colón</option>
                                    <option value="Comayagua" <?php echo e((old('departamento', $proveedor->departamento) == 'Comayagua') ? 'selected' : ''); ?>>Comayagua</option>
                                    <option value="Copán" <?php echo e((old('departamento', $proveedor->departamento) == 'Copán') ? 'selected' : ''); ?>>Copán</option>
                                    <option value="Cortés" <?php echo e((old('departamento', $proveedor->departamento) == 'Cortés') ? 'selected' : ''); ?>>Cortés</option>
                                    <option value="El Paraíso" <?php echo e((old('departamento', $proveedor->departamento) == 'El Paraíso') ? 'selected' : ''); ?>>El Paraíso</option>
                                    <option value="Francisco Morazán" <?php echo e((old('departamento', $proveedor->departamento) == 'Francisco Morazán') ? 'selected' : ''); ?>>Francisco Morazán</option>
                                    <option value="Gracias a Dios" <?php echo e((old('departamento', $proveedor->departamento) == 'Gracias a Dios') ? 'selected' : ''); ?>>Gracias a Dios</option>
                                    <option value="Intibucá" <?php echo e((old('departamento', $proveedor->departamento) == 'Intibucá') ? 'selected' : ''); ?>>Intibucá</option>
                                    <option value="Islas de la Bahía" <?php echo e((old('departamento', $proveedor->departamento) == 'Islas de la Bahía') ? 'selected' : ''); ?>>Islas de la Bahía</option>
                                    <option value="La Paz" <?php echo e((old('departamento', $proveedor->departamento) == 'La Paz') ? 'selected' : ''); ?>>La Paz</option>
                                    <option value="Lempira" <?php echo e((old('departamento', $proveedor->departamento) == 'Lempira') ? 'selected' : ''); ?>>Lempira</option>
                                    <option value="Ocotepeque" <?php echo e((old('departamento', $proveedor->departamento) == 'Ocotepeque') ? 'selected' : ''); ?>>Ocotepeque</option>
                                    <option value="Olancho" <?php echo e((old('departamento', $proveedor->departamento) == 'Olancho') ? 'selected' : ''); ?>>Olancho</option>
                                    <option value="Santa Bárbara" <?php echo e((old('departamento', $proveedor->departamento) == 'Santa Bárbara') ? 'selected' : ''); ?>>Santa Bárbara</option>
                                    <option value="Valle" <?php echo e((old('departamento', $proveedor->departamento) == 'Valle') ? 'selected' : ''); ?>>Valle</option>
                                    <option value="Yoro" <?php echo e((old('departamento', $proveedor->departamento) == 'Yoro') ? 'selected' : ''); ?>>Yoro</option>
                                </select>
                                <?php $__errorArgs = ['departamento'];
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

                    </div>

                    
                    <div class="text-center mt-5 d-flex justify-content-center gap-3">
                        <a href="<?php echo e(route('Proveedores.indexProveedor')); ?>" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>
                        <a href="<?php echo e(route('Proveedores.edit', $proveedor->id)); ?>"
                           class="btn btn-warning">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    
    <?php $__env->startPush('scripts'); ?>
        <script>
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
    <?php $__env->stopPush(); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/Proveedores/edit.blade.php ENDPATH**/ ?>