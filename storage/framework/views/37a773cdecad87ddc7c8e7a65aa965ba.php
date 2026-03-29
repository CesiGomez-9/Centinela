<?php $__env->startSection('titulo', 'Configurar 2FA'); ?>
<?php $__env->startSection('content'); ?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    body { font-family: 'Inter', sans-serif; }
    .card-2fa {
        border: none;
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        background: #fff;
        max-width: 600px;
    }
    .card-header-2fa {
        background-color: #0d1b2a;
        padding: 1.5rem 1.75rem;
        border-bottom: 4px solid #cda34f;
    }
    .card-header-2fa h5 { color: #fff; font-weight: 700; font-size: 1.3rem; margin: 0; }
    .card-header-2fa p  { color: #f0e6d2; font-size: 0.85rem; margin: 0.3rem 0 0; }
    .step-badge {
        background-color: #cda34f;
        color: #fff;
        border-radius: 50%;
        width: 28px; height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .qr-wrapper {
        background: #f9f9f9;
        border: 2px dashed #cda34f;
        border-radius: 10px;
        padding: 1rem;
        display: inline-block;
    }
    .secret-box {
        background: #f1f3f5;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        font-family: monospace;
        font-size: 1rem;
        letter-spacing: 0.15em;
        color: #0d1b2a;
        word-break: break-all;
    }
    .form-control:focus { border-color: #cda34f; box-shadow: 0 0 0 3px rgba(205,163,79,0.2); }
    .btn-activate {
        background-color: #cda34f;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: background 0.2s;
    }
    .btn-activate:hover { background-color: #0d1b2a; color: #fff; }
    .alert-warning-custom {
        background: #fff8e1;
        border: 1px solid #cda34f;
        border-radius: 8px;
        padding: 0.8rem 1rem;
        font-size: 0.875rem;
        color: #6d4c00;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <?php if(session('warning')): ?>
                <div class="alert-warning-custom mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e(session('warning')); ?>

                </div>
            <?php endif; ?>

            <div class="card-2fa">
                <div class="card-header-2fa">
                    <h5><i class="bi bi-shield-lock me-2"></i>Configurar Autenticación de Dos Factores</h5>
                    <p>Añade una capa extra de seguridad a tu cuenta</p>
                </div>
                <div class="p-4">

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger rounded-3 mb-3">
                            <i class="bi bi-x-circle me-1"></i> <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <span class="step-badge mt-1">1</span>
                        <div>
                            <strong>Descarga una app de autenticación</strong>
                            <p class="text-muted small mb-0 mt-1">
                                Instala <strong>Google Authenticator</strong> o <strong>Authy</strong> en tu teléfono.
                            </p>
                        </div>
                    </div>

                    
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <span class="step-badge mt-1">2</span>
                        <div class="w-100">
                            <strong>Escanea el código QR</strong>
                            <p class="text-muted small mb-3 mt-1">
                                Abre la app, toca <em>"Agregar cuenta"</em> y escanea el código.
                            </p>
                            <div class="text-center mb-3">
                                <?php if($qrCode): ?>
                                    <div class="qr-wrapper">
                                        <img src="<?php echo e($qrCode); ?>" alt="QR Code 2FA" width="180" height="180">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="text-muted small text-center mb-1">¿No puedes escanear? Ingresa este código manualmente:</p>
                            <div class="secret-box text-center mb-0"><?php echo e($secret); ?></div>
                        </div>
                    </div>

                    
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <span class="step-badge mt-1">3</span>
                        <div class="w-100">
                            <strong>Ingresa el código para confirmar</strong>
                            <p class="text-muted small mb-3 mt-1">
                                La app generará un código de 6 dígitos. Ingrésalo para activar 2FA.
                            </p>
                            <form method="POST" action="<?php echo e(route('two-factor.enable')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <input type="text" name="code" class="form-control form-control-lg text-center"
                                           placeholder="000000" maxlength="6" inputmode="numeric"
                                           style="letter-spacing:0.4em; font-size:1.4rem;" autofocus autocomplete="one-time-code">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn-activate">
                                        <i class="bi bi-shield-check me-2"></i>Activar autenticación de dos factores
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/auth/two_factor_setup.blade.php ENDPATH**/ ?>