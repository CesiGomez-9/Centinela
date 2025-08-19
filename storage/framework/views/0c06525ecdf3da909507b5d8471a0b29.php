<?php $__env->startSection('titulo', 'Detalle de Venta'); ?>
<?php $__env->startSection('content'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
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
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .card-header .header-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }

        .card-header .header-title i {
            margin-right: 0.5rem;
        }

        .card-header small {
            color: #ffffff;
            font-weight: 700;
            font-size: 0.8rem;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            flex-shrink: 0;
        }

        .card-body {
            padding: 2.25rem 1.75rem;
            font-size: 1rem;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .card-body p {
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
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

        .btn-return {
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-return:hover, .btn-return:focus {
            background-color: #0d1b2a;
            color: #ffffff;
            text-decoration: none;
        }

        @media (max-width: 767.98px) {
            .card-body {
                padding: 1.75rem 1rem;
                font-size: 0.95rem;
            }

            .btn-return {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }

            .card-header h5 {
                margin-left: 0;
                text-align: center;
            }

            .card-header small {
                position: static;
                transform: none;
                text-align: center;
                display: block;
                margin-top: 5px;
            }
        }

        .section-header {
            margin-top: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #cda34f;
            color: #0d1b2a;
            font-weight: 700;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 768px) {
            .details-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .details-grid .detail-item {
            padding: 15px 20px;
            border-radius: 8px;
            background-color: #fdfdfd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .details-grid .detail-item strong {
            display: block;
            font-size: 0.95rem;
            color: #1b263b;
            margin-bottom: 5px;
        }

        .details-grid .detail-item span {
            font-size: 0.9rem;
            color: #555;
        }

        .product-table-container {
            margin-top: 2rem;
            margin-bottom: 0.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-table-container table {
            margin-bottom: 0;
        }

        .product-table-container th,
        .product-table-container td {
            font-size: 0.9rem;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .product-table-container thead th {
            background-color: #f2f2f2;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #cda34f;
        }

        .product-table-container tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product-table-container tbody tr:hover {
            background-color: #e6f0ff;
        }

        .invoice-summary-totals {
            margin-top: 0.5rem;
        }

        .invoice-summary-totals .summary-box {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1px 35px;
            background-color: #fdfdfd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .invoice-summary-totals .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.875rem;
        }

        .invoice-summary-totals .summary-item strong {
            color: #0d1b2a;
            font-weight: 600;
        }

        .invoice-summary-totals .summary-item span {
            font-weight: 500;
            color: #333;
            font-size: 0.875rem;
        }

        .invoice-summary-totals .summary-item.total {
            font-size: 1rem;
            font-weight: 700;
            border-top: 2px solid #cda34f;
            padding-top: 6px;
            margin-top: 15px;
        }

        /* Estilo para el recuadro único y las columnas */
        .single-detail-box {
            padding: 20px;
            border-radius: 8px;
            background-color: #fdfdfd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-top: 1rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        @media (min-width: 768px) {
            .single-detail-box {
                grid-template-columns: repeat(2, 1fr);
            }
            .single-detail-box .full-width-item {
                grid-column: 1 / -1;
            }
        }
        .single-detail-box p {
            margin-bottom: 0;
            line-height: 1.6;
        }
        .single-detail-box b {
            font-weight: 600;
        }
    </style>

    <div class="container py-1">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <div class="header-title"><i class="bi bi-calendar-check me-2"></i>Detalle de la venta de servicio</div>
                        </h5>
                        <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                            Creado <?php echo e($turno->created_at->diffForHumans()); ?>

                        </small>
                    </div>
                    <div class="card-body">
                        <h6 class="section-header">
                            Servicio: <?php echo e($turno->servicio->nombre ?? 'N/A'); ?>

                        </h6>
                        <div class="single-detail-box">
                            <p><b>Cliente:</b> <?php echo e($turno->cliente->nombre ?? 'N/A'); ?> <?php echo e($turno->cliente->apellido ?? 'N/A'); ?></p>
                            <p><b>Servicio:</b> <?php echo e($turno->servicio->nombre ?? 'N/A'); ?></p>
                            <p><b>Fecha de inicio:</b> <?php echo e(\Carbon\Carbon::parse($turno->fecha_inicio ?? now())->format('d/m/Y')); ?>.</p>
                            <p><b>Fecha de fin:</b> <?php echo e(\Carbon\Carbon::parse($turno->fecha_fin ?? now())->format('d/m/Y')); ?>.</p>
                            <p><b>Categoría:</b> <?php echo e(Str::ucfirst($turno->servicio->categoria ?? 'N/A')); ?>.</p>
                            <div class="full-width-item d-flex gap-4">
                                <p class="w-50"><b>Descripción:</b> <?php echo e(Str::ucfirst($turno->servicio->descripcion ?? 'N/A')); ?>.</p>
                                <p class="w-50"><b>Observaciones:</b> <?php echo e($turno->observaciones ?? 'N/A'); ?>.</p>
                            </div>
                        </div>

                        <h6 class="section-header mt-5">
                            Empleados Asignados
                        </h6>

                        <div class="table-responsive product-table-container">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre del Empleado</th>
                                    <th>Tipo de Turno</th>
                                    <th>Hora de Inicio</th>
                                    <th>Hora de Fin</th>
                                    <th>Costo (Lps)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $turno->empleados_asignados ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e(is_array($detalle['empleado_nombres']) ? implode(', ', $detalle['empleado_nombres']) : $detalle['empleado_nombres']); ?></td>
                                        <td><?php echo e(Str::ucfirst($detalle['tipo_turno'] ?? 'N/A')); ?></td>
                                        <td><?php echo e($detalle['hora_inicio'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($detalle['hora_fin'] ?? 'N/A'); ?></td>
                                        <td><?php echo e(number_format($detalle['costo'] ?? 0, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-muted fst-italic py-3">No hay empleados asignados para este servicio.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-6 col-lg-5">
                                <div class="invoice-summary-totals">
                                    <div class="summary-box">
                                        <div class="summary-item total">
                                            <strong>Costo total(Lps):</strong>
                                            <?php
                                                $total_costo = 0;
                                                foreach ($turno->empleados_asignados ?? [] as $detalle) {
                                                    $total_costo += $detalle['costo'] ?? 0;
                                                }
                                            ?>
                                            <span><?php echo e(number_format($total_costo, 2)); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <small>Última actualización: <?php echo e($turno->updated_at->diffForHumans()); ?></small>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                    <a href="<?php echo e(route('turnos.index')); ?>" class="btn-return">
                        <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/turnos/show.blade.php ENDPATH**/ ?>