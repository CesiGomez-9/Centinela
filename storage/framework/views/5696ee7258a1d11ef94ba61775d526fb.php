<?php $__env->startSection('content'); ?>
    <div class="container mt-5" style="background-color: #bcd0e4; min-height: 90vh;">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4 py-3">
                        <h4 class="mb-0">
                            <i class="bi bi-shield-lock-fill me-2"></i>Asignar rol
                        </h4>
                    </div>

                    <form id="formRoles" action="<?php echo e(route('roles.guardar', $user->id)); ?>" method="POST" class="p-4">
                        <?php echo csrf_field(); ?>

                        
                        <div id="alerta" class="alert alert-warning d-none" role="alert">
                            Debe seleccionar un rol antes de guardar.
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nombre del rol</label>
                            <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-person-badge-fill text-primary"></i>
                            </span>
                                <select name="role" id="roleSelect" class="form-select form-select-lg border-primary">
                                    <option value="">Seleccione un rol </option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($role->name); ?>" <?php echo e($user->hasRole($role->name) ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst($role->name)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Permisos de este rol</label>
                            <div class="border rounded-4 p-3 bg-white" style="max-height: 260px; overflow-y:auto; column-count:2;">
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="permissions[]"
                                               value="<?php echo e($permission->id); ?>"
                                               id="perm-<?php echo e($permission->id); ?>"
                                            <?php echo e(in_array($permission->id, $userPermissions) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="perm-<?php echo e($permission->id); ?>">
                                            <i class="bi bi-key-fill me-1 text-secondary"></i>
                                            <?php echo e(ucfirst($permission->name)); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        
                        <div class="d-flex justify-content-between gap-2 botones">
                            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-danger w-100">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>

                            <button type="button" class="btn btn-secondary w-100" id="btnLimpiar">
                                <i class="bi bi-eraser-fill me-2"></i> Limpiar
                            </button>

                            <button type="submit" class="btn btn-warning w-100 text-white fw-normal" style="background-color: #6cb2eb; border-color: #6cb2eb;">
                                <i class="bi bi-save-fill me-2"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <style>
        body {
            background-color: #bcd0e4;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .form-select:focus, .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        .card-header.bg-primary {
            background-color: #0d6efd !important;
        }
        .input-group-text {
            border-right: 0;
        }
        .form-select {
            border-left: 0;
        }
    </style>

    
    <script>
        const form = document.getElementById('formRoles');
        const alerta = document.getElementById('alerta');
        const roleSelect = document.getElementById('roleSelect');

        // Validación al enviar
        form.addEventListener('submit', function(e) {
            if (roleSelect.value === "") {
                e.preventDefault();
                alerta.classList.remove('d-none');
            } else {
                alerta.classList.add('d-none');
            }
        });

        // Limpiar formulario
        document.getElementById('btnLimpiar').addEventListener('click', function() {
            form.reset();
            form.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            alerta.classList.add('d-none');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/roles_permisos/asignar.blade.php ENDPATH**/ ?>