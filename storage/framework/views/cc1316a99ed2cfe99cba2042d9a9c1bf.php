<?php $__env->startSection('titulo', 'Detalles de la incidencia'); ?>

<?php $__env->startSection('content'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('https://www.transparenttextures.com/patterns/beige-paper.png') repeat fixed #f8f4ec;
            font-size: 16px;
        }

        .card {
            border: none;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            background: #ffffff;
            min-height: 400px;
            max-width: 1000px;
            transition: transform 0.2s ease-in-out;

        }



        .card:hover {
            transform: scale(1.01);
        }

        .card-header {
            background-color: #0d1b2a;
            padding: 1.75rem 1.75rem;
            border-bottom: 4px solid #cda34f;
        }

        .card-header h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .card-header small {
            color: #f0e6d2;
            font-size: 0.85rem;
        }

        .card-body {
            padding: 2.25rem 1.75rem;
            font-size: 1rem;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .card-body p {
            margin-bottom: 1.3rem;
            border-left: 4px solid #cda34f;
            padding-left: 0.75rem;
        }

        .card-body i {
            color: #1b263b;
        }

        .card-body strong {
            color: #0d1b2a;
            font-weight: 600;
        }

        .card-footer {
            background-color: #1b263b;
            padding: 0.9rem 1.5rem;
            border-top: 1px solid #cda34f;
            font-size: 0.9rem;
        }

        .card-footer small {
            color: #f5f5f5;
        }

        .btn-return, .btn-edit {
            background-color: #cda34f;
            color: #ffffff;
            border: none;
            padding: 0.7rem 1.6rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            margin: 0 0.5rem;
        }

        .btn-return:hover, .btn-edit:hover,
        .btn-return:focus, .btn-edit:focus {
            background-color: #0d1b2a;
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .card-body {
                padding: 1.75rem 1rem;
                font-size: 0.95rem;
            }

            .btn-return, .btn-edit {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card">
                    <div class="card-header position-relative">
                        <h5 class="mb-0"><i class="bi bi-building me-2"></i>Detalles de la incidencia</h5>
                        <small class="position-absolute top-50 end-0 translate-middle-y me-3">Creado <?php echo e($incidencia->created_at->diffForHumans()); ?></small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><i class="bi bi-calendar3 me-2"></i><strong>Fecha:</strong> <?php echo e($incidencia->fecha); ?></p>
                                <p><i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Tipo:</strong> <?php echo e($incidencia->tipo); ?></p>
                                <p><i class="bi bi-geo-alt-fill me-2"></i><strong>Ubicación:</strong> <?php echo e($incidencia->ubicacion); ?></p>
                                <p><i class="bi bi-card-text me-2"></i><strong>Descripción:</strong> <?php echo e($incidencia->descripcion); ?></p>
                            </div>

                            <div class="col-md-6">
                                <p><i class="bi bi-people-fill me-2"></i>  <strong>Empleados involucrados:</strong>
                                    <?php $__currentLoopData = $incidencia->agentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($agente->nombre); ?> <?php echo e($agente->apellido); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></p>
                                <p><i class="bi bi-person-fill-check me-2"></i><strong>Reportado por:</strong>
                                    <?php echo e($incidencia->reportadoPorEmpleado->nombre ?? '---'); ?> <?php echo e($incidencia->reportadoPorEmpleado->apellido ?? ''); ?>

                                </p>

                                <p><i class="bi bi-building-fill me-2"></i><strong>Cliente afectado:</strong>
                                    <?php echo e($incidencia->cliente->nombre ?? '---'); ?> <?php echo e($incidencia->cliente->apellido ?? ''); ?>

                                </p>
                                <p><i class="bi bi-clipboard-check-fill me-2"></i><strong>Estado:</strong> <?php echo e($incidencia->estado); ?></p>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <small>Última actualización: <?php echo e($incidencia->updated_at->diffForHumans()); ?></small>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                    <a href="<?php echo e(route('incidencias.index')); ?>" class="btn btn-return">
                        <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                    </a>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/incidencias/detalle.blade.php ENDPATH**/ ?>