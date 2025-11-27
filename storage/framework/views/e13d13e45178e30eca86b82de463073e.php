<?php $__env->startSection('content'); ?>

    <style>
        .tabla-roles td {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }
        .bg-rol {
            background-color: #f0f8ff !important;
        }
    </style>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-shield-lock-fill me-2"></i>Lista de roles y permisos
            </h3>

            
            <form method="GET" action="<?php echo e(route('roles_permisos.index')); ?>" class="mb-4 row align-items-end">
                
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre..."
                               value="<?php echo e(request('search')); ?>" id="searchInput">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-shield-lock-fill me-1"></i> Rol</span>
                        <select name="rol" class="form-select" id="rolSelect">
                            <option value="">Todos...</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->name); ?>" <?php echo e(request('rol') == $role->name ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($role->name)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                
                <div class="col-md-4 d-flex justify-content-start">
                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-md btn-outline-primary">
                        <i class="bi bi-pencil-square me-2"></i> Listado usuarios
                    </a>
                </div>
            </form>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped tabla-roles align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="bg-rol">
                            <td><?php echo e($loop->iteration + ($users->currentPage() - 1) * $users->perPage()); ?></td>
                            <td><?php echo e($user->empleado->nombre ?? $user->nombre); ?> <?php echo e($user->empleado->apellido ?? ''); ?></td>
                            <td>
                                <?php if($user->roles->isNotEmpty()): ?>
                                    <?php echo e($user->roles->pluck('name')->implode(', ')); ?>

                                <?php else: ?>
                                    <span class="text-muted">Sin rol</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(route('roles_permisos.ver', $user->id)); ?>" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye-fill"></i> Ver
                                </a>
                                <a href="<?php echo e(route('roles_permisos.editar', $user->id)); ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($users->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filtroForm = document.querySelector('form');
            const rolSelect = document.querySelector('#rolSelect');
            const searchInput = document.querySelector('#searchInput');

            // Filtrar automáticamente al cambiar rol
            rolSelect.addEventListener('change', function () {
                filtroForm.submit();
            });

            // Filtrar automáticamente al escribir en el buscador (espera 0.5s)
            let timeout = null;
            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filtroForm.submit();
                }, 500);
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/roles_permisos/index.blade.php ENDPATH**/ ?>