<?php $__env->startSection('titulo', 'Factura de Compra'); ?>
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
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .card-header h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.4rem;
            text-align: center;
            flex-grow: 0;
            margin-left: 0;
        }

        .card-header small {
            color: #f0e6d2;
            font-size: 0.85rem;
            position: absolute;
            top: 50%;
            right: 1.75rem;
            transform: translateY(-50%);
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

            .card-header .logo-container {
                position: static;
                transform: none;
                margin-bottom: 10px;
                justify-content: center;
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
            margin-top: 2rem;
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

        .invoice-header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            align-items: stretch;
            gap: 20px;
        }

        @media (max-width: 767.98px) {
            .invoice-header-info {
                flex-direction: column;
            }
        }

        .invoice-header-info .supplier-details,
        .invoice-header-info .invoice-details {
            flex: 1;
            min-width: 280px;
            padding: 15px 20px;
            border-radius: 8px;
            background-color: #fdfdfd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .supplier-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            gap: 10px;
        }

        .supplier-details .logo-and-name {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 5px;
        }

        .supplier-details img {
            max-width: 120px;
            height: auto;
            border-radius: 5px;
            flex-shrink: 0;
            display: none;
        }

        .supplier-details strong {
            font-size: 0.9rem;
            display: block;
            margin-bottom: 0;
        }

        .supplier-address-contact p {
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
        }

        .invoice-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            text-align: left;
        }

        .invoice-details .invoice-details-grid {
            display: block;
            width: 100%;
        }

        .invoice-details .invoice-details-grid > div {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .invoice-details .invoice-details-grid strong {
            display: inline;
            margin-right: 5px;
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
            padding: 15px;
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
            padding-top: 10px;
            margin-top: 15px;
        }
    </style>

    <div class="container py-1">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card">
                    <div class="card-header position-relative">
                        <h5 class="mb-0">
                            <i class="bi bi-receipt-cutoff me-2"></i>Factura de Compra
                        </h5>
                        <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                            Creado <?php echo e($factura->created_at->diffForHumans()); ?>

                        </small>
                    </div>
                    <div class="card-body">
                        <div class="invoice-header-info">
                            <div class="supplier-details">
                                <div class="logo-and-name">
                                    <strong><?php echo e($factura->proveedor->nombreEmpresa ?? 'N/A'); ?></strong>
                                </div>
                                <div class="supplier-address-contact">
                                    <p><strong>Dirección:</strong> <?php echo e($factura->proveedor->direccion ?? 'N/A'); ?>.</p>
                                    <p><strong>Teléfono de la empresa:</strong> <?php echo e($factura->proveedor->telefonodeempresa ?? 'N/A'); ?>.</p>
                                    <p><strong>Email:</strong> <?php echo e($factura->proveedor->correoempresa ?? 'N/A'); ?>.</p>
                                    <p><strong>Representante:</strong> <?php echo e($factura->proveedor->nombrerepresentante ?? 'N/A'); ?>.</p>
                                    <p><strong>Teléfono Representante:</strong> <?php echo e($factura->proveedor->telefonoderepresentante ?? 'N/A'); ?>.</p>
                                </div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-details-grid">
                                    <div><strong>Factura de compra N°:</strong> <?php echo e($factura->numero_factura ?? 'N/A'); ?>.</div>
                                    <div><strong>Fecha de la factura:</strong> <?php echo e(\Carbon\Carbon::parse($factura->fecha ?? now())->format('d/m/Y')); ?>.</div>
                                    <div><strong>Proveedor:</strong> <?php echo e($factura->proveedor->nombreEmpresa ?? 'N/A'); ?>.</div>
                                    <div><strong>Forma de pago:</strong> <?php echo e($factura->forma_pago ?? 'N/A'); ?>.</div>
                                    <div><strong>Responsable:</strong> <?php echo e($factura->empleado->nombre ?? 'N/A'); ?> <?php echo e($factura->empleado->apellido ?? 'N/A'); ?>.</div>
                                </div>
                            </div>
                        </div>

                        <h6 class="section-header">
                            Productos comprados
                        </h6>

                        <div class="table-responsive product-table-container">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Descripción</th>
                                    <th>Precio(Lps)</th>
                                    <th>Cantidad</th>
                                    <th>IVA%</th> 
                                    <th>Subtotal(Lps)</th> 
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $factura->detalles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        // Calcula el IVA y el subtotal por línea dinámicamente
                                        $ivaPorcentaje = $detalle->productoInventario->impuesto->porcentaje ?? 0;
                                        $subtotalLinea = $detalle->precio_compra * $detalle->cantidad;
                                    ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($detalle->productoInventario->nombre ?? 'Producto Desconocido'); ?></td>
                                        <td><?php echo e(number_format($detalle->precio_compra, 2)); ?></td>
                                        <td><?php echo e($detalle->cantidad); ?></td>
                                        <td><?php echo e(number_format($ivaPorcentaje, 0)); ?>%</td> 
                                        <td><?php echo e(number_format($subtotalLinea, 2)); ?></td> 
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-muted fst-italic py-3">No hay productos agregados a esta factura.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        
                        <div class="row justify-content-end">
                            <div class="col-md-6 col-lg-5">
                                <div class="invoice-summary-totals">
                                    <div class="summary-box">
                                        <div class="summary-item">
                                            <strong>Importe Gravado (Lps):</strong>
                                            <span><?php echo e(number_format($factura->importe_gravado ?? 0, 2)); ?></span>
                                        </div>
                                        <div class="summary-item">
                                            <strong>Importe Exento (Lps):</strong>
                                            <span><?php echo e(number_format($factura->importe_exento ?? 0, 2)); ?></span>
                                        </div>
                                        <div class="summary-item">
                                            <strong>Importe Exonerado (Lps):</strong>
                                            <span><?php echo e(number_format($factura->importe_exonerado ?? 0, 2)); ?></span>
                                        </div>
                                        <div class="summary-item">
                                            <strong>Subtotal (Lps):</strong>
                                            <span><?php echo e(number_format($factura->subtotal ?? 0, 2)); ?></span>
                                        </div>
                                        <div class="summary-item">
                                            <strong>ISV 15% (Lps):</strong>
                                            <span><?php echo e(number_format($factura->isv_15 ?? 0, 2)); ?></span>
                                        </div>
                                        <div class="summary-item">
                                            <strong>ISV 18% (Lps):</strong>
                                            <span><?php echo e(number_format($factura->isv_18 ?? 0, 2)); ?></span>
                                        </div>
                                        <div class="summary-item total">
                                            <strong>Total Final (Lps):</strong>
                                            <span><?php echo e(number_format($factura->totalF ?? 0, 2)); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <small>Última actualización: <?php echo e($factura->updated_at->diffForHumans()); ?></small>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                    <a href="<?php echo e(route('facturas_compras.index')); ?>" class="btn-return">
                        <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/facturas_compras/show.blade.php ENDPATH**/ ?>