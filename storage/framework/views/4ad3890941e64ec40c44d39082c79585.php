<?php $__env->startSection('titulo', 'Códigos de Recuperación'); ?>
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .card-recovery { border:none; border-radius:1.25rem; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.2); max-width:520px; }
    .card-header-r { background-color:#0d1b2a; padding:1.5rem 1.75rem; border-bottom:4px solid #cda34f; }
    .card-header-r h5 { color:#fff; font-weight:700; font-size:1.2rem; margin:0; }
    .code-grid { display:grid; grid-template-columns:1fr 1fr; gap:0.5rem; }
    .code-item {
        background:#f1f3f5; border:1px solid #dee2e6; border-radius:6px;
        padding:0.5rem 0.75rem; font-family:monospace; font-size:0.95rem;
        color:#0d1b2a; letter-spacing:0.1em; text-align:center;
    }
    .btn-back { background-color:#cda34f; color:#fff; border:none; border-radius:8px; padding:0.65rem 1.5rem; font-weight:600; }
    .btn-back:hover { background-color:#0d1b2a; color:#fff; }
    .alert-warning-box { background:#fff8e1; border:1px solid #cda34f; border-radius:8px; padding:0.9rem 1rem; font-size:0.875rem; color:#6d4c00; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card-recovery">
                <div class="card-header-r">
                    <h5><i class="bi bi-key me-2"></i>Códigos de Recuperación</h5>
                </div>
                <div class="p-4">

                    <?php if(session('status')): ?>
                        <div class="alert alert-success rounded-3 mb-3">
                            <i class="bi bi-check-circle me-1"></i> <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="alert-warning-box mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Guarda estos códigos en un lugar seguro.</strong>
                        Cada código solo puede usarse una vez. Si pierdes acceso a tu app de autenticación,
                        podrás usar uno de estos códigos para iniciar sesión.
                    </div>

                    <div class="code-grid mb-4">
                        <?php $__currentLoopData = $recoveryCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="code-item"><?php echo e($code); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('index')); ?>" class="btn-back">
                            <i class="bi bi-house me-1"></i>Ir al inicio
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary border-0" style="background:#f1f3f5; border-radius:8px; padding:0.65rem 1rem;">
                            <i class="bi bi-printer me-1"></i>Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/auth/two_factor_recovery_codes.blade.php ENDPATH**/ ?>