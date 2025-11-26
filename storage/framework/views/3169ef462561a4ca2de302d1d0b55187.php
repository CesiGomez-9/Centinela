<?php $__env->startSection('content'); ?>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    </head>

    <style>
        body {
            background-color: #e6f0ff;
            color: #000000;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 750px;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 15px;
            background-color: #1a2340;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            color: #ffffff;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #ffffff;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-bottom: 10px;
            background-color: #2a3357;
            color: #fff;
            font-size: 15px;
        }

        input[readonly] {
            background-color: #3a4467;
            cursor: not-allowed;
        }

        .botones {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        .btn i {
            vertical-align: middle;
        }
    </style>

    <div class="container">
        <h1 style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #ffffff;">
            Perfil del usuario
            <i class="bi bi-person-fill" style="font-size: 2rem;"></i>
        </h1>

        <form>
            <?php echo csrf_field(); ?>
            <div class="grid-2">

                
                <div class="full">
                    <div class="input-icon">
                        <i class="bi bi-person-fill"></i>  Empleado:
                        <input type="text" value="<?php echo e($user->empleado->nombre); ?> <?php echo e($user->empleado->apellido); ?>" readonly>
                    </div>
                </div>

                
                <div class="full">
                    <div class="input-icon">
                        <i class="bi bi-envelope-fill"></i>  Correo electrónico:
                        <input type="email" value="<?php echo e($user->email); ?>" readonly>
                    </div>
                </div>

                
                <div class="full">
                    <div class="input-icon">
                        <i class="bi bi-person-badge-fill"></i> Usuario:
                        <input type="text" value="<?php echo e($user->usuario); ?>" readonly>
                    </div>
                </div>

                
                <div class="full">
                    <div class="input-icon">
                        <i class="bi bi-shield-lock-fill"></i>  Rol:
                        <input type="text" value="<?php echo e($user->rol); ?>" readonly>
                    </div>
                </div>

            </div>
            <div class="btn-center" style="gap: 50px; flex-wrap: wrap;">
                <!-- Botón volver a la lista -->
                <a href="<?php echo e(route('users.index')); ?>" class="btn w-50" style="background-color: #cda34f; color: #1a2340;">
                    <i class="bi bi-arrow-left me-2"></i> Volver a la lista
                </a>

                <!-- Botón ver permisos -->
                <a href="<?php echo e(route('users.verpermisos', $user->id)); ?>" class="btn w-25" style="background-color: #cda34f; color: #1a2340;">
                    <i class="bi bi-eye-fill me-2"></i> Ver permisos
                </a>
            </div>






        </form>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/users/show.blade.php ENDPATH**/ ?>