<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información del Servicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
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

        .btn-return:hover, .btn-edit:hover {
            background-color: #0d1b2a;
            color: #ffffff;
        }

        ul {
            list-style-type: disc;
        }

        /* Estilos para los items de costo */
        .cost-item {
            margin-bottom: 0.5rem;
            border-left: 4px solid #cda34f;
            padding-left: 0.6rem;
        }
        .cost-item strong {
            display: inline-block;
            min-width: 70px; /* Ajusta este valor si necesitas más espacio para la etiqueta */
            text-align: left;
            margin-right: 5px;
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="<?php echo e(asset('centinela.jpg')); ?>" style="height:80px; margin-right: 10px;">
            Grupo Centinela
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrate</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>Información del Servicio</h5>
                    <small class="position-absolute top-50 end-0 translate-middle-y me-3 text-white-50">
                        Creado <?php echo e(\Carbon\Carbon::parse($servicio->created_at)->diffForHumans()); ?>

                    </small>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <p><i class="bi bi-card-text me-2"></i><strong>Nombre:</strong> <?php echo e($servicio->nombre); ?></p>
                            <p><i class="bi bi-paragraph me-2"></i><strong>Descripción:</strong> <?php echo e($servicio->descripcion); ?></p>

                            <!-- Mostrar la etiqueta "Costos:" y luego los tres costos -->
                            <p class="mb-1">
                                <i class="bi bi-cash-coin me-1"></i>
                                <strong>Costos:</strong>
                            </p>
                            <div class="cost-item">
                                <i class="bi bi-sun me-2"></i><strong>Diurno:</strong> L. <?php echo e(number_format($servicio->costo_diurno, 2)); ?>

                            </div>
                            <div class="cost-item">
                                <i class="bi bi-moon me-2"></i><strong>Nocturno:</strong> L. <?php echo e(number_format($servicio->costo_nocturno, 2)); ?>

                            </div>
                            <div class="cost-item">
                                <i class="bi bi-clock me-2"></i><strong>24 Horas:</strong> L. <?php echo e(number_format($servicio->costo_24_horas, 2)); ?>

                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <p class="mb-1">
                                <i class="bi bi-diagram-3-fill me-1"></i>
                                <strong>Categoría:</strong> <?php echo e(ucfirst($servicio->categoria)); ?>

                            </p>

                            <p class="mb-1">
                                <i class="bi bi-box-seam me-1"></i>
                                <strong>Productos requeridos:</strong>
                            </p>

                            <?php if($productos->count() > 0): ?>
                                <?php if($productos->count() > 3): ?>
                                    <div class="row">
                                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-6 col-sm-12 mb-1">
                                                • <?php echo e($producto->nombre); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <p class="mb-0">
                                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            • <?php echo e($producto->nombre); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="ms-4"><em>No hay productos específicos requeridos.</em></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <small class="text-white-50">Última actualización: <?php echo e($servicio->updated_at ? $servicio->updated_at->diffForHumans() : 'Fecha no disponible'); ?></small>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                <a href="<?php echo e(route('servicios.catalogo')); ?>" class="btn btn-return">
                    <i class="bi bi-arrow-left me-2"></i>Volver al catálogo
                </a>
                <a href="<?php echo e(route('servicios.edit', $servicio->id)); ?>" class="btn btn-edit">
                    <i class="bi bi-pencil-square me-2"></i>Editar servicio
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/servicios/show.blade.php ENDPATH**/ ?>