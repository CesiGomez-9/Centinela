<?php $__env->startSection('content'); ?>

<?php if(session('info')): ?>
    <div class="alert alert-info alert-dismissible fade show mt-3 mx-3" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i> <?php echo e(session('info')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>


<style>
    body {
        background-color: #f8f4ec;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        margin: 0;
        padding: 0;
    }

    .card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        background: #ffffff;
        max-width: 1100px;
        margin: 10px auto;
    }

    .card-header {
        background-color: #0a1f3a;
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid #cda34f;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .card-header h5 {
        color: #ffffff;
        font-weight: 600;
        font-size: 1.15rem;
        margin: 0;
    }

    .card-header small {
        color: #dcdcdc;
        font-size: 0.75rem;
    }

    .section-header {
        background-color: #0a1f3a;
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid #cda34f;
        text-align: center;
        margin-top: 0.5rem;
        border-radius: 0;
    }

    .section-header h5 {
        color: #ffffff;
        font-weight: 600;
        font-size: 1.15rem;
        margin: 0;
    }

    .card-body {
        padding: 0.8rem 1.2rem 0.5rem 1.2rem;
        font-size: 0.95rem;
    }

    .card-body p {
        margin-bottom: 0.5rem;
        border-left: 4px solid #cda34f;
        padding-left: 0.6rem;
    }

    .card-body i {
        color: #1b263b;
    }

    .card-body strong {
        color: #0d1b2a;
        font-weight: 600;
    }

    .card-footer {
        background-color: #0a1f3a;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        color: #f5f5f5;
        text-align: right;
        border-top: 1px solid #cda34f;
        margin-top: 15px;

    }

    .btn-return, .btn-edit {
        background-color: #cda34f;
        color: #ffffff;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        font-size: 0.95rem;
        margin: 0 0.5rem;
    }

    .btn-return:hover, .btn-edit:hover,
    .btn-return:focus, .btn-edit:focus {
        background-color: #0d1b2a;
        color: #ffffff;
    }

    @media (max-width: 767.98px) {
        .card-body {
            padding: 0.8rem;
            font-size: 0.9rem;
        }

        .btn-return, .btn-edit {
            display: block;
            width: 100%;
            margin: 0.5rem 0;
        }
    }

    .d-flex.align-items-center.gap-3 {
        margin-top: 1rem;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <div class="card">
                <div class="card-header position-relative">
                    <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i>Información del empleado</h5>
                    <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                        Creado: <?php echo e($empleado->created_at ? $empleado->created_at->diffForHumans() : 'Fecha no disponible'); ?>

                    </small>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p><i class="bi bi-person-fill me-2"></i><strong>Nombre:</strong> <?php echo e($empleado->nombre); ?></p>
                            <p><i class="bi bi-person-fill me-2"></i><strong>Apellido:</strong> <?php echo e($empleado->apellido); ?></p>
                            <p><i class="bi bi-credit-card-2-front-fill me-2"></i><strong>Identidad:</strong> <?php echo e($empleado->identidad); ?></p>
                            <p><i class="bi bi-geo-alt-fill me-2"></i><strong>Departamento:</strong> <?php echo e($empleado->departamento); ?></p>
                            <p><i class="bi bi-geo-alt-fill me-2"></i><strong>Dirección:</strong> <?php echo e($empleado->direccion); ?></p>
                            <p><i class="bi bi-list me-2"></i><strong>Categoría:</strong> <?php echo e($empleado->categoria); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="bi bi-envelope-fill me-2"></i><strong>Correo:</strong> <?php echo e($empleado->email); ?></p>
                            <p><i class="bi bi-telephone-fill me-2"></i><strong>Teléfono:</strong> <?php echo e($empleado->telefono); ?></p>
                            <p><i class="bi bi-droplet-fill me-2"></i><strong>Tipo de sangre:</strong> <?php echo e($empleado->tipodesangre); ?></p>
                            <p><i class="bi bi-exclamation-diamond-fill me-2"></i><strong>Alergias:</strong></p>

                            <?php
                                $alergiasArray = [];

                                if (is_string($empleado->alergias)) {
                                    $alergiasArray = array_map('trim', explode(',', $empleado->alergias));
                                } elseif (is_array($empleado->alergias)) {
                                    $alergiasArray = $empleado->alergias;
                                }
                            ?>

                            <?php if(count($alergiasArray) > 0): ?>
                                <ul class="mb-0 ps-4">
                                    <?php $__currentLoopData = $alergiasArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alergia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <?php echo e($alergia); ?>


                                            <?php if($alergia === 'Alimentos' && !empty($empleado->alergiaAlimentos)): ?>
                                                : <?php echo e($empleado->alergiaAlimentos); ?>

                                            <?php elseif($alergia === 'Medicamentos' && !empty($empleado->alergiaMedicamentos)): ?>
                                                : <?php echo e($empleado->alergiaMedicamentos); ?>

                                            <?php elseif($alergia === 'Otros' && !empty($empleado->alergiaOtros)): ?>
                                                : <?php echo e($empleado->alergiaOtros); ?>

                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                <p><em>No tiene alergias registradas.</em></p>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="section-header mt-4">
                        <h5 class="mb-0"><i class="bi bi-person-badge-fill me-2"></i>Contacto de emergencia</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="bi bi-person-lines-fill me-2"></i><strong>Nombre completo:</strong> <?php echo e($empleado->contactodeemergencia); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="bi bi-telephone-plus-fill me-2"></i><strong>Teléfono:</strong> <?php echo e($empleado->telefonodeemergencia); ?></p>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <small>Última actualización: <?php echo e($empleado->updated_at ? $empleado->updated_at->diffForHumans() : 'Fecha no disponible'); ?></small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                <a href="<?php echo e(route('empleados.index')); ?>" class="btn btn-return">
                    <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                </a>
                <a href="<?php echo e(route('empleados.edit', $empleado->id)); ?>" class="btn btn-edit">
                    <i class="bi bi-pencil-square me-2"></i>Editar empleado
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/empleados/show.blade.php ENDPATH**/ ?>