<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center py-5">
        <div class="col-lg-7 col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header text-white rounded-top-4 py-3 text-center" style="background-color: #1a2340;">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-lock-fill me-2"></i>Editar rol
                    </h4>
                </div>

                <form id="formRoles" action="<?php echo e(route('roles_permisos.actualizar', $user->id)); ?>" method="POST" class="p-4 bg-white rounded-bottom-4 text-start">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="mb-4 position-relative">
                        <label class="form-label fw-bold">Nombre del rol</label>
                        <div class="input-group shadow-sm rounded">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-person-badge-fill text-primary"></i>
                        </span>
                            <select name="role" id="roleSelect" class="form-select border-0">
                                <option value="">Seleccione un rol</option>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($role->name !== 'super_admin'): ?>
                                        <option value="<?php echo e($role->name); ?>" <?php echo e($user->hasRole($role->name) ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst($role->name)); ?>

                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div id="alertaRol" class="form-text text-danger d-none mt-1">
                            Debe seleccionar un rol antes de guardar.
                        </div>
                    </div>

                    
                    <div class="mb-4 position-relative">
                        <label class="form-label fw-bold">Permisos de este rol</label>

                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-bold" for="selectAll">
                                <i class="bi bi-check2-all me-1 text-primary"></i> Seleccionar todos
                            </label>
                        </div>

                        <div class="border rounded-4 p-3 bg-light shadow-sm" style="max-height: 260px; overflow-y:auto; column-count:2;">
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input permission-checkbox"
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
                        <div id="alertaPermisos" class="form-text text-danger d-none mt-1">
                            Seleccione al menos un permiso.
                        </div>
                    </div>

                    
                    <div class="d-flex justify-content-between gap-2 botones">
                        <a href="<?php echo e(route('roles_permisos.index')); ?>" class="btn btn-outline-danger w-100 fw-bold hover-shadow">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <button type="button" class="btn btn-outline-secondary w-100 fw-bold hover-shadow" id="btnRestablecer">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                        </button>

                        <button type="submit" class="btn btn-primary w-100 fw-bold hover-shadow text-white">
                            <i class="bi bi-save-fill me-2"></i> Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <style>
        body { background-color: #e6f0ff; font-family: 'Segoe UI', Arial, sans-serif; }
        .form-check-input:checked { background-color: #192e4c; border-color: #03284c; }
        .form-select:focus, .form-check-input:focus { box-shadow: 0 0 0 0.2rem rgba(25, 46, 76, 0.25); }
        .input-group { border: 1px solid #ced4da; border-radius: 0.5rem; overflow: hidden; }
        .form-select { border: none; }
        .form-text.text-danger { font-size: 0.85rem; text-align: left; }
        .btn:hover { filter: brightness(0.95); transition: 0.3s; }
        .hover-shadow:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .card { border-radius: 1rem; min-height: 500px; }
        .bg-light { background-color: #f7f9fc !important; }
        .card-header { font-weight: 600; font-size: 1.1rem; letter-spacing: 0.5px; }
        .border::-webkit-scrollbar { width: 6px; }
        .border::-webkit-scrollbar-thumb { background-color: rgba(25,46,76,0.5); border-radius: 3px; }
    </style>

    
    <script>
        const form = document.getElementById('formRoles');
        const roleSelect = document.getElementById('roleSelect');
        const alertaRol = document.getElementById('alertaRol');
        const permisos = form.querySelectorAll('.permission-checkbox');
        const alertaPermisos = document.getElementById('alertaPermisos');
        const selectAllCheckbox = document.getElementById('selectAll');

        // Guardar valores originales para restablecer
        const originalRole = roleSelect.value;
        const originalPermissions = Array.from(permisos).map(cb => cb.checked);

        // Validación del formulario
        form.addEventListener('submit', function(e) {
            let valid = true;

            if (roleSelect.value === "") {
                e.preventDefault();
                alertaRol.classList.remove('d-none');
                valid = false;
            } else {
                alertaRol.classList.add('d-none');
            }

            let anyChecked = Array.from(permisos).some(cb => cb.checked);
            if (!anyChecked) {
                e.preventDefault();
                alertaPermisos.classList.remove('d-none');
                valid = false;
            } else {
                alertaPermisos.classList.add('d-none');
            }

            return valid;
        });

        // Restablecer
        document.getElementById('btnRestablecer').addEventListener('click', function() {
            roleSelect.value = originalRole;
            permisos.forEach((cb, i) => cb.checked = originalPermissions[i]);
            selectAllCheckbox.checked = Array.from(permisos).every(cb => cb.checked);
            alertaRol.classList.add('d-none');
            alertaPermisos.classList.add('d-none');
        });

        // Lógica "Seleccionar todos"
        selectAllCheckbox.addEventListener('change', function() {
            permisos.forEach(cb => cb.checked = this.checked);
        });

        permisos.forEach(cb => {
            cb.addEventListener('change', function() {
                selectAllCheckbox.checked = Array.from(permisos).every(c => c.checked);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/roles_permisos/editar.blade.php ENDPATH**/ ?>