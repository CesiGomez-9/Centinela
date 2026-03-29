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
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: scale(1.01);
        }

        .card-header {
            background-color: #0d1b2a;
            padding: 1.75rem 1.75rem;
            border-bottom: 4px solid #cda34f;
            display: flex;
            justify-content: center;
            align-items: center;
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
            font-size: 0.9rem;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .card-body p {
            margin-bottom: 1.3rem;
            border-left: 4px solid #cda34f;
            padding-left: 0.75rem;
            font-size: 0.9rem;
        }

        .card-body i {
            color: #1b263b;
            font-size: 1rem;
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

        .btn-return{
            background-color: #cda34f;
            color: #ffffff;
            border: none;
            padding: 0.7rem 1.6rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
            margin: 0 0.5rem;
        }

        .btn-return:hover,
        .btn-return:focus{
            background-color: #0d1b2a;
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .card-body {
                padding: 1.75rem 1rem;
                font-size: 0.9rem;
            }

            .btn-return {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
        .price-history-card .card-header {
            background-color: #1b263b;
            border-bottom: 4px solid #cda34f;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .price-history-card .card-header .header-title {
            color: #ffffff;
            font-size: 1.1rem;
        }

        .price-history-card .card-header .header-title i {
            margin-right: 0.5rem;
        }

        .table-price-history {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1rem;
            font-size: 0.9rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .table-price-history th,
        .table-price-history td {
            padding: 0.9rem 1.2rem;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
            border-right: 1px solid #e9ecef;
            font-size: 0.9rem;
        }

        .table-price-history th:last-child,
        .table-price-history td:last-child {
            border-right: none;
        }

        .table-price-history thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #343a40;
            border-bottom: 2px solid #dee2e6;
        }

        .table-price-history tbody tr:nth-child(even) {
            background-color: #fdfdfd;
        }

        .table-price-history tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .table-price-history tbody tr:hover {
            background-color: #eef5ff;
        }

        .price-change-up {
            color: #28a745;
            font-weight: bold;
        }

        .price-change-down {
            color: #dc3545;
            font-weight: bold;
        }

        .price-change-neutral {
            color: #6c757d;
            font-weight: normal;
        }
        .pagination {
            justify-content: center;
            margin-top: 1.5rem;
        }
        .pagination .page-item .page-link {
            color: #0d1b2a;
            border: 1px solid #cda34f;
            border-radius: 0.25rem;
            margin: 0 0.25rem;
            transition: all 0.3s ease-in-out;
        }
        .pagination .page-item.active .page-link {
            background-color: #cda34f;
            border-color: #cda34f;
            color: white;
        }
        .pagination .page-item .page-link:hover {
            background-color: #0d1b2a;
            border-color: #0d1b2a;
            color: white;
        }
    </style>

    <div class="container py-1">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title"><i class="bi bi-boxes me-2"></i>Detalles del producto.</div>
                        <?php if(isset($producto)): ?>
                            <small>Creado <?php echo e($producto->created_at ? $producto->created_at->diffForHumans() : 'Fecha no disponible'); ?>.</small>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><i class="bi bi-upc-scan me-2"></i><strong>Código:</strong> <?php echo e($producto->codigo); ?>.</p>
                                <p><i class="bi bi-qr-code me-2"></i><strong>Serie:</strong> <?php echo e($producto->serie); ?>.</p>
                                <p><i class="bi bi-card-text me-2"></i><strong>Nombre:</strong> <?php echo e($producto->nombre); ?>.</p>
                                <p><i class="bi bi-tag me-2"></i><strong>Marca:</strong> <?php echo e($producto->marca); ?>.</p>
                                <p><i class="bi bi-cpu me-2"></i><strong>Modelo:</strong> <?php echo e($producto->modelo); ?>.</p>
                                <p><i class="bi bi-briefcase-fill me-2"></i><strong>Categoría:</strong> <?php echo e($producto->categoria); ?>.</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-box-fill me-2"></i><strong>Cantidad actual:</strong> <?php echo e(floor($producto->cantidad)); ?>.</p>
                                <p><i class="bi bi-percent me-2"></i><strong>Impuesto:</strong> <?php echo e($producto->impuesto->nombre ?? 'N/A'); ?> (<?php echo e($producto->impuesto->porcentaje ?? '0'); ?>%).</p>
                                <p><i class="bi bi-currency-dollar me-2"></i><strong>Precio de compra actual:</strong> Lps. <?php echo e(number_format($producto->precio_compra, 2)); ?>.</p>
                                <p><i class="bi bi-cash-stack me-2"></i><strong>Precio de venta actual:</strong> Lps. <?php echo e(number_format($producto->precio_venta, 2)); ?>.</p>
                                <p><i class="bi bi-pencil-square me-2"></i><strong>Descripción:</strong> <br><?php echo e($producto->descripcion); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <small>Última actualización: <?php echo e($producto->updated_at ? $producto->updated_at->diffForHumans() : 'Fecha no disponible'); ?>.</small>
                    </div>
                </div>

                <div class="card price-history-card">
                    <div class="card-header">
                        <div class="header-title"><i class="bi bi-graph-up-arrow me-2"></i>Variación de precios de compra.</div>
                    </div>
                    <div class="card-body">
                        <?php if($precioComprasPaginadas->isNotEmpty()): ?>
                            <div class="table-responsive">
                                <table class="table table-price-history">
                                    <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Precio</th>
                                        <th>Cambio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $precioComprasPaginadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $precioHistorial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(($precioComprasPaginadas->currentPage() - 1) * $precioComprasPaginadas->perPage() + $loop->iteration); ?></td>
                                            <td><?php echo e($precioHistorial->created_at->format('d/m/Y H:i')); ?></td>
                                            <td>Lps. <?php echo e(number_format($precioHistorial->precio_compra, 2)); ?></td>
                                            <td>
                                                <?php if($precioHistorial->previous_price !== null): ?>
                                                    <?php if($precioHistorial->precio_compra > $precioHistorial->previous_price): ?>
                                                        <span class="price-change-up"><i class="bi bi-arrow-up-circle-fill me-1"></i> Subió (Lps. <?php echo e(number_format($precioHistorial->precio_compra - $precioHistorial->previous_price, 2)); ?>)</span>
                                                    <?php elseif($precioHistorial->precio_compra < $precioHistorial->previous_price): ?>
                                                        <span class="price-change-down"><i class="bi bi-arrow-down-circle-fill me-1"></i> Bajó (Lps. <?php echo e(number_format($precioHistorial->previous_price - $precioHistorial->precio_compra, 2)); ?>)</span>
                                                    <?php else: ?>
                                                        <span class="price-change-neutral"><i class="bi bi-dash-circle-fill me-1"></i> Sin cambio</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="price-change-neutral">Precio inicial</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo e($precioComprasPaginadas->links()); ?>

                        <?php else: ?>
                            <p class="text-center text-muted">No hay historial de precios de compra para este producto.</p>
                        <?php endif; ?>
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

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/productos/show.blade.php ENDPATH**/ ?>