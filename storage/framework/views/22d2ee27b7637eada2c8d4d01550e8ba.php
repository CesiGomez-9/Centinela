<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema de Seguridad Centinela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            position: relative;
            overflow: hidden;
            /* Fondo con degradado y glow radial */
            background: linear-gradient(135deg, #0f2c5c, #1b3e80);
        }

        /* Glow radial detrás de la tarjeta */
        body::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 900px;
            height: 700px;
            background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);
            z-index: 0;
        }

        .login-card {
            width: 400px;
            padding: 3rem;
            background: #112b52;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.5);
            color: #ffffff;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card .icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #3b82f6;
        }

        .login-card h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-card p {
            margin-bottom: 1.5rem;
            color: #cbd5e1;
        }

        .form-control {
            background: transparent !important;
            border: 1px solid #3b82f6;
            border-radius: 10px;
            color: #ffffff;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59,130,246,0.5);
            color: #ffffff;
        }

        .btn-login {
            width: 100%;
            background: #3b82f6;
            color: #ffffff;
            border: none;
            font-weight: bold;
            padding: 0.8rem;
            border-radius: 12px;
            font-size: 1rem;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #1e40af;
            color: #ffffff;
        }

        .text-small {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 15px;
        }

        @media (max-width: 450px) {
            .login-card {
                width: 90%;
                padding: 2.5rem;
            }
        }

        .form-control::placeholder {
            color: #ffffff; /* blanco */
            opacity: 1;     /* evita que se vea gris tenue */
        }
    </style>
</head>
<body>



<div class="login-card">
    <i class="bi bi-shield-lock-fill icon"></i>
    <h2>Bienvenido</h2>
    <p>Grupo Centinela</p>
<<<<<<< HEAD
=======
    
>>>>>>> Ana

    <form action="<?php echo e(route('login.process')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <!-- Usuario -->
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text"
                   class="form-control"
                   id="usuario"
                   name="usuario"
<<<<<<< HEAD
                   maxlength="30"
=======
                   maxlength="50"
>>>>>>> Ana
                   placeholder="Ingrese su usuario"
                   value="<?php echo e(old('usuario')); ?>">
            <?php $__errorArgs = ['usuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="text-danger mt-1" style="font-size: 0.9rem;">
                <?php echo e($message); ?>

            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password"
                   class="form-control"
                   id="password"
                   name="password"
<<<<<<< HEAD
                   maxlength="8"
=======
                   maxlength="20"
>>>>>>> Ana
                   placeholder="Ingrese su contraseña">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="text-danger mt-1" style="font-size: 0.9rem;">
                <?php echo e($message); ?>

            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button class="btn btn-login" type="submit">
            <i class="bi bi-box-arrow-in-right"></i> Ingresar
        </button>
    </form>

    <p class="text-small">
        <a href="<?php echo e(route('password.request')); ?>" style="color:#3b82f6; text-decoration: none;">
            ¿Olvidaste tu contraseña?
        </a>
    </p>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
</body>
</html>
<?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/auth/login.blade.php ENDPATH**/ ?>