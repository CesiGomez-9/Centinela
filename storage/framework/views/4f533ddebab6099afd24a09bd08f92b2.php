<?php $__env->startSection('content'); ?>
    <style>
        .btn-outline-success-custom {
            color: #28a745;
            border: 1px solid #28a745;
            background-color: transparent;
            transition: all 0.2s ease-in-out;
        }

        .btn-outline-success-custom:hover,
        .btn-outline-success-custom:focus {
            background-color: #55ca6f;
            color: #155724;
            border-color: #28a745;
        }

        /* Campos y botones uniformes */
        .date-filter input,
        .date-filter button,
        .date-filter a {
            min-width: 150px;
            font-size: 12px;
        }

        .date-filter .d-flex {
            gap: 5px;
        }
    </style>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>
                Lista de usuarios
            </h3>

            <?php
                $hoy = date('Y-m-d');
                $maxFecha = date('Y-m-d', strtotime('+2 months'));
            ?>

            <form method="GET" action="<?php echo e(route('users.index')); ?>">
                <div class="row mb-4 align-items-center">
                    <!-- Buscador -->
                    <div class="col-md-4 d-flex justify-content-start">
                        <div class="w-100">
                            <div class="input-group">
                                <input
                                    type="text"
                                    id="searchInput"
                                    name="search"
                                    value="<?php echo e(request('search')); ?>"
                                    class="form-control"
                                    placeholder="Buscar por nombre o usuario..."
                                    autocomplete="off"
                                />
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Filtro por fecha centrado -->
                    <div class="col-md-4 date-filter d-flex flex-column align-items-center">
                        <div class="d-flex mb-2 justify-content-center">
                            <input type="date" name="fecha_inicio" class="form-control form-control-sm"
                                   value="<?php echo e(request('fecha_inicio', $hoy)); ?>" min="<?php echo e($hoy); ?>" max="<?php echo e($maxFecha); ?>">
                            <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                        </div>
                        <div class="d-flex justify-content-center">
                            <input type="date" name="fecha_fin" class="form-control form-control-sm"
                                   value="<?php echo e(request('fecha_fin', $hoy)); ?>" min="<?php echo e($hoy); ?>" max="<?php echo e($maxFecha); ?>">
                            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-sm btn-secondary">Limpiar</a>
                        </div>
                    </div>

                    <!-- Registrar nuevo usuario -->
                    <div class="col-md-4 d-flex justify-content-end">
                        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-md btn-outline-primary">
                            <i class="bi bi-pencil-square me-2"></i> Registrar nuevo usuario
                        </a>
                    </div>
                </div>
            </form>

            <?php if(session('mensaje')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo e(session('mensaje')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                     <th>Creado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($users->firstItem() + $loop->index); ?></td>
                        <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                            <?php echo e($user->empleado->nombre ?? $user->name); ?> <?php echo e($user->empleado->apellido ?? $user->apellido); ?>

                        </td>
                        <td><?php echo e($user->usuario ?? '—'); ?></td>
                         <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('users.show', $user->id)); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="<?php echo e(route('roles.asignar', $user->id)); ?>"
                               class="btn btn-sm btn-warning">
                                Asignar Rol
                            </a>


                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <?php if(request('search') && $users->total() > 0): ?>
                <div class="mb-3 text-muted">
                    Mostrando <?php echo e($users->count()); ?> de <?php echo e($users->total()); ?> usuarios encontrados para
                    "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php elseif(request('search') && $users->total() === 0): ?>
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($users->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/users/index.blade.php ENDPATH**/ ?>