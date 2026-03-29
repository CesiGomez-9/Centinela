<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación 2FA | Sistema de Seguridad Centinela</title>
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
            background: url('<?php echo e(asset("camara.jpg")); ?>') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(10, 20, 40, 0.65);
            backdrop-filter: blur(3px);
            z-index: 0;
        }
        .card-login {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(205, 163, 79, 0.3);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            backdrop-filter: blur(12px);
            color: #fff;
        }
        .logo-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #cda34f;
            margin-bottom: 0.5rem;
        }
        .title { font-size: 1.4rem; font-weight: 700; color: #fff; }
        .subtitle { color: #cda34f; font-size: 0.85rem; margin-bottom: 1.5rem; }
        .form-label { color: #d0d8e8; font-size: 0.85rem; margin-bottom: 0.3rem; }
        .form-control {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(205,163,79,0.35);
            color: #fff;
            border-radius: 8px;
            padding: 0.65rem 1rem;
            letter-spacing: 0.3em;
            font-size: 1.2rem;
            text-align: center;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.12);
            border-color: #cda34f;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(205,163,79,0.2);
            outline: none;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3); letter-spacing: normal; font-size: 0.9rem; }
        .btn-login {
            background: linear-gradient(135deg, #cda34f, #a07830);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            padding: 0.7rem;
            width: 100%;
            font-size: 1rem;
            transition: opacity 0.2s;
        }
        .btn-login:hover { opacity: 0.9; color: #fff; }
        .alert-danger-custom {
            background: rgba(220,53,69,0.15);
            border: 1px solid rgba(220,53,69,0.4);
            color: #f8a0a8;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }
        .hint-text { color: rgba(255,255,255,0.45); font-size: 0.78rem; }
        .divider { border-color: rgba(205,163,79,0.2); margin: 1.2rem 0; }
        .recovery-link { color: #cda34f; font-size: 0.82rem; text-decoration: none; }
        .recovery-link:hover { color: #e8bf6a; text-decoration: underline; }
    </style>
</head>
<body>
<div class="card-login text-center">
    <img src="<?php echo e(asset('logo.png')); ?>" alt="Logo" class="logo-img" onerror="this.style.display='none'">
    <div class="title mt-2">Verificación de Identidad</div>
    <div class="subtitle">Autenticación de dos factores</div>

    <?php if($errors->any()): ?>
        <div class="alert-danger-custom mb-3">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <p class="hint-text mb-3">
        Abre tu app de autenticación (Google Authenticator, Authy) e ingresa el código de 6 dígitos.
    </p>

    <form method="POST" action="<?php echo e(route('two-factor.verify.post')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3 text-start">
            <label class="form-label">Código de verificación</label>
            <input type="text" name="code" class="form-control" placeholder="000 000"
                   maxlength="7" autocomplete="one-time-code" autofocus inputmode="numeric">
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-shield-check me-2"></i>Verificar
        </button>
    </form>

    <hr class="divider">
    <p class="hint-text mb-1">¿No tienes acceso a tu app?</p>
    <a href="#" class="recovery-link" onclick="toggleRecovery()">
        <i class="bi bi-key me-1"></i>Usar código de recuperación
    </a>

    <form method="POST" action="<?php echo e(route('two-factor.verify.post')); ?>" id="recovery-form" class="mt-3" style="display:none">
        <?php echo csrf_field(); ?>
        <input type="text" name="code" class="form-control mb-2"
               placeholder="XXXXX-XXXXX" autocomplete="off" style="letter-spacing:0.1em; font-size:1rem;">
        <button type="submit" class="btn-login">
            <i class="bi bi-key me-2"></i>Acceder con código de recuperación
        </button>
    </form>

    <div class="mt-3">
        <a href="<?php echo e(route('login')); ?>" class="recovery-link">
            <i class="bi bi-arrow-left me-1"></i>Volver al inicio de sesión
        </a>
    </div>
</div>
<script>
    function toggleRecovery() {
        const f = document.getElementById('recovery-form');
        f.style.display = f.style.display === 'none' ? 'block' : 'none';
    }
    // Auto-formatear código TOTP
    document.querySelector('input[inputmode="numeric"]').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 6);
    });
</script>
</body>
</html>
<?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/auth/two_factor_verify.blade.php ENDPATH**/ ?>