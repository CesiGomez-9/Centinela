<?php $__env->startSection('content'); ?>

    <style>
        body {
            background-color: #BCD0E4FF;
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        .card {
            background-color: rgba(26, 35, 64, 0.95);
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            max-width: 950px;
            margin: 40px auto;
            padding: 25px;
            color: #fff;
        }

        .card-header {
            background-color: #cda34f;
            padding: 15px 20px;
            border-radius: 0.8rem 0.8rem 0 0;
            font-size: 1.3rem;
            font-weight: 600;
            text-align: center;
            color: #1a2340;
        }

        .card-body {
            padding: 20px;
        }

        .user-info p {
            margin-bottom: 10px;
            border-left: 4px solid #cda34f;
            padding-left: 10px;
            color: #fff;
        }

        .user-info i {
            margin-right: 8px;
            color: #cda34f;
        }

        .modulo-titulo {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #cda34f;
            border-bottom: 1px solid #cda34f55;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .modulo-card {
            background-color: #1e2b4a;
            border: 1px solid #2a3357;
            border-radius: 0.7rem;
            padding: 14px;
        }

        .permiso-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            padding: 4px 0;
        }

        .permiso-item .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dot-activo  { background-color: #28a745; }
        .dot-inactivo { background-color: #555; }

        .text-inactivo { color: #666; }

        .modulos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .roles-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 4px;
        }

        .badge-rol {
            background-color: #cda34f;
            color: #1a2340;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .btn-center {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        .btn-return {
            background-color: #cda34f;
            color: #1a2340;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }

        .btn-return:hover {
            background-color: #0d1b2a;
            color: #fff;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-shield-lock-fill me-2"></i> Roles y permisos del usuario
        </div>

        <div class="card-body">
            <div class="user-info mb-3">
                <p><i class="bi bi-person-fill"></i><strong>Nombre:</strong> <?php echo e($user->empleado->nombre); ?> <?php echo e($user->empleado->apellido); ?></p>
                <p><i class="bi bi-envelope-fill"></i><strong>Correo:</strong> <?php echo e($user->email); ?></p>
                <p><i class="bi bi-person-badge-fill"></i><strong>Usuario:</strong> <?php echo e($user->usuario); ?></p>
                <p>
                    <i class="bi bi-shield-fill-check"></i><strong>Roles asignados:</strong>
                    <span class="roles-badges">
                        <?php $__empty_1 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <span class="badge-rol"><?php echo e($role->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <span class="text-warning">Sin rol asignado</span>
                        <?php endif; ?>
                    </span>
                </p>
            </div>

            <hr style="border-color: #cda34f55;">
            <h6 class="mb-3" style="color: #cda34f;">Permisos por módulo</h6>

            <?php if($user->roles->isEmpty()): ?>
                <div class="text-center text-warning py-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Este usuario no tiene roles asignados, por lo tanto no tiene permisos.
                </div>
            <?php else: ?>
                <div class="modulos-grid">
                    <?php $__currentLoopData = $permisosPorModulo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo => $permisos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $tieneAlguno = collect($permisos)->some(fn($p) => $permisosDelUsuario->contains($p));
                        ?>
                        <div class="modulo-card">
                            <div class="modulo-titulo"><?php echo e($modulo); ?></div>
                            <?php $__currentLoopData = $permisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($permisosDelUsuario->contains($permiso)): ?>
                                    <div class="permiso-item">
                                        <span class="dot dot-activo"></span>
                                        <span><?php echo e(ucfirst($permiso)); ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="permiso-item text-inactivo">
                                        <span class="dot dot-inactivo"></span>
                                        <span><?php echo e(ucfirst($permiso)); ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <div class="btn-center">
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-return">
                    <i class="bi bi-arrow-left me-2"></i> Volver a la lista
                </a>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Centinela\resources\views/users/verPermisos.blade.php ENDPATH**/ ?>