<?php $__env->startSection('titulo', 'Detalles del producto'); ?>
<?php $__env->startSection('content'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        .card-header {
            background-color: #0d1b2a;
            padding: 1rem 1rem;
            border-bottom: 3px solid #cda34f;
        }

        .card-header h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .card-header small {
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
        }

    </style>

    <div class="container py-1">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card">
                    <div class="card-header position-relative">
                        <h5 class="mb-0" style="font-size: 0.9rem;"><i class="bi bi-boxes me-2"></i>Detalles del producto</h5>
                        <small class="position-absolute top-50 end-0 translate-middle-y me-3">Creado <?php echo e($producto->created_at->diffForHumans()); ?></small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><i class="bi bi-upc-scan me-2"></i><strong>Código:</strong> <?php echo e($producto->codigo); ?></p>
                                <p><i class="bi bi-qr-code me-2"></i><strong>Serie:</strong> <?php echo e($producto->serie); ?></p>
                                <p><i class="bi bi-card-text me-2"></i><strong>Nombre:</strong> <?php echo e($producto->nombre); ?></p>
                                <p><i class="bi bi-tag me-2"></i><strong>Marca:</strong> <?php echo e($producto->marca); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-cpu me-2"></i><strong>Modelo:</strong> <?php echo e($producto->modelo); ?></p>
                                <p><i class="bi bi-briefcase-fill me-2"></i><strong>Categoría:</strong> <?php echo e($producto->categoria); ?></p>
                                <p><i class="bi bi-percent me-2"></i><strong>IVA:</strong> <?php echo e($producto->material); ?></p>
                                <p><i class="bi bi-pencil-square me-2"></i><strong>Descripción:</strong> <br><?php echo e($producto->descripcion); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <small>Última actualización: <?php echo e($producto->updated_at->diffForHumans()); ?></small>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                    <a href="<?php echo e(route('productos.index')); ?>" class="btn btn-return">
                        <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                    </a>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/productos/show.blade.php ENDPATH**/ ?>