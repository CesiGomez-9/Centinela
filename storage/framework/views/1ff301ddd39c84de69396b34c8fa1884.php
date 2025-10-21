<?php $__env->startSection('titulo', 'Detalles de la Asistencia'); ?>

<?php $__env->startSection('content'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('https://www.transparenttextures.com/patterns/beige-paper.png') repeat fixed #f8f4ec;
            font-size: 15px;
        }

        .card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: #ffffff;
            max-width: 750px;
            margin: 0 auto;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.01);
        }

        .card-header {
            background-color: #0d1b2a;
            padding: 1.2rem 1.5rem;
            border-bottom: 3px solid #cda34f;
        }

        .card-header h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
        }

        .card-header small {
            color: #f0e6d2;
            font-size: 0.8rem;
        }

        .card-body {
            padding: 1.6rem 1.5rem;
            font-size: 0.95rem;
        }

        .card-body p {
            margin-bottom: 1rem;
            border-left: 3px solid #cda34f;
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
            background-color: #1b263b;
            padding: 0.7rem 1.2rem;
            border-top: 1px solid #cda34f;
            font-size: 0.85rem;
        }

        .card-footer small {
            color: #f5f5f5;
        }

        .btn-return {
            background-color: #cda34f;
            color: #ffffff;
            border: none;
            padding: 0.55rem 1.2rem;
            border-radius: 0.4rem;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            font-size: 0.95rem;
            margin-top: 1.2rem;
        }

        .btn-return:hover,
        .btn-return:focus {
            background-color: #0d1b2a;
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .card {
                max-width: 90%;
            }

            .card-body {
                padding: 1.2rem;
                font-size: 0.9rem;
            }

            .btn-return {
                width: 100%;
            }
        }
    </style>

    <div class="container py-5">
        <div class="card">
            <div class="card-header position-relative">
                <h5><i class="bi bi-clipboard-check me-2"></i>Detalles de la asistencia</h5>
                <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                    Creado <?php echo e($asistencia->created_at->diffForHumans()); ?>

                </small>
            </div>

            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <p><i class="bi bi-person-fill me-2"></i><strong>Empleado:</strong>
                            <?php echo e($asistencia->nombre); ?> <?php echo e($asistencia->apellido); ?>

                        </p>
                        <p><i class="bi bi-credit-card-2-front me-2"></i><strong>Identidad:</strong>
                            <?php echo e($asistencia->identidad); ?>

                        </p>
                        <p><i class="bi bi-calendar-event me-2"></i><strong>Fecha:</strong>
                            <?php echo e($asistencia->created_at ? $asistencia->created_at->format('d/m/Y') : '-'); ?>

                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><i class="bi bi-clock-history me-2"></i><strong>Hora de entrada:</strong>
                            <?php echo e($asistencia->hora_entrada ?? 'No registrada'); ?>

                        </p>
                        <p><i class="bi bi-clock me-2"></i><strong>Hora de salida:</strong>
                            <?php echo e($asistencia->hora_salida ?? 'No registrada'); ?>

                        </p>
                        <p><i class="bi bi-calendar-week me-2"></i><strong>Tipo de turno:</strong>
                            <?php echo e($asistencia->turno ? $asistencia->turno->tipo_turno : 'Sin turno asignado'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <small>Última actualización: <?php echo e($asistencia->updated_at->diffForHumans()); ?></small>
            </div>
        </div>

        <div class="text-center">
            <a href="<?php echo e(route('asistencias.index')); ?>" class="btn btn-return">
                <i class="bi bi-arrow-left me-2"></i>Volver a la lista
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/asistencias/show.blade.php ENDPATH**/ ?>