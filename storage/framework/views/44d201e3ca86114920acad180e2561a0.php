<?php $__env->startSection('titulo', 'Asignación de servicio'); ?>
<?php $__env->startSection('content'); ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('https://www.transparenttextures.com/patterns/beige-paper.png') repeat fixed #f8f4ec;
            font-size: 16px;
        }
        .card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            background: #ffffff;
            max-width: 850px;
            margin: 2rem auto;
            transition: transform 0.2s ease-in-out;

        }
        .card:hover {
            transform: scale(1.01);
        }
        .card-header {
            background-color: #0d1b2a;
            padding: 1.75rem 1.75rem;
            border-bottom: 4px solid #cda34f;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            border-top-left-radius: 1.25rem;
            border-top-right-radius: 1.25rem;
        }
        .card-header h5 {
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .card-header small {
            position: absolute;
            right: 1.75rem;
            font-size: 0.85rem;
            color: #f0e6d2;
            top: 50%;
            transform: translateY(-50%);
        }
        .card-body {
            padding: 2.25rem 2rem;
            font-size: 1rem;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
            border-radius: 0;
        }
        .card-footer {
            background-color: #1b263b;
            padding: 0.9rem 1.5rem;
            font-size: 0.9rem;
            color: #f5f5f5;
            text-align: right;
            border-radius: 0 0 1.25rem 1.25rem;
            border: none;
        }
        .card-interno {
            background: #f9f9f9;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgb(205 163 79 / 0.15);
            height: 100%;
        }
        .section-header {
            margin-top: 1rem;
            padding-bottom: 0.5rem;
            border-top: 4px solid #cda34f;
            color: #0d1b2a;
            font-weight: 700;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        table.table > tbody > tr > td,
        table.table > thead > tr > th {
            vertical-align: middle;
        }
        .totales-card {
            background: #f9f9f9;
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 8px rgb(205 163 79 / 0.15);
        }
        .totales-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: #0d1b2a;
        }
        .totales-row.total {
            border-top: 2px solid #cda34f;
            padding-top: 0.75rem;
            font-size: 1.1rem;
            font-weight: 700;
        }
        .btn-warning {
            background-color: #cda34f;
            border-color: #cda34f;
            color: #0d1b2a;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-warning:hover {
            background-color: #0d1b2a;
            color: #fff;
        }
        table.table thead tr {
            border-bottom: 4px solid #cda34f;
        }
    </style>


<div class="card position-relative">
    <div class="card-header text-center">
        <h5><i class="bi bi-file-earmark-text"></i> Factura de venta</h5>
        <small>Creada hace <?php echo e($factura->created_at->diffForHumans()); ?></small>
    </div>

    <div class="card-body">
        <div class="container px-4"> <!-- Contenedor para padding horizontal -->
            <img src="<?php echo e(asset('centinela.jpg')); ?>" alt="Logo Centinela" width="90" />
            <div class="text-center mb-4" style="margin-top: -20px;">
                <div class="d-flex justify-content-center align-items-center mb-3 gap-3">
                    <h4 class="fw-bold mb-0">GRUPO CENTINELA</h4>
                </div>
                <p class="mb-1"><strong>RTN:</strong> 06021999123456</p>
                <p class="mb-1"><strong>Teléfono fijo: </strong>+504 2763-3585</p>
                <p class="mb-1"><strong>Celular:</strong> +504 9322-5352</p>
                <p class="mb-1"><strong>Email: </strong>grupocentinela.hn@gmail.com</p>
                <p class="mb-1"><strong>Dirección:</strong> Barrio Oriental, cuatro cuadras al sur del parque central, Danlí, El Paraíso, Honduras.</p>

            </div>

            <div class="mb-5 mt-5">
                <div class="d-flex mb-2 gap-4">
                    <p class="mb-0"><strong>Factura de venta N°:</strong> <?php echo e($factura->numero); ?></p>
                    <p class="mb-0"><strong>Fecha:</strong> <?php echo e(\Carbon\Carbon::parse($factura->fecha)->format('d/m/Y')); ?></p>
                    <p class="mb-0"><strong>Cliente:</strong> <?php echo e($factura->cliente->nombre ?? ''); ?> <?php echo e($factura->cliente->apellido ?? ''); ?></p>
                </div>
                <div class="d-flex gap-4">
                    <p class="mb-0"><strong>Forma de pago:</strong> <?php echo e($factura->forma_pago); ?></p>
                    <p class="mb-0"><strong>Responsable:</strong> <?php echo e($factura->responsable->nombre ?? ''); ?> <?php echo e($factura->responsable->apellido ?? ''); ?></p>
                </div>
            </div>

            <h6 class="section-header"><i class="bi bi-box-seam"></i> Productos vendidos</h6>
            <div class="table-responsive product-table-container">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>N°</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio (Lps)</th>
                        <th>Cantidad</th>
                        <th>IVA%</th>
                        <th>Subtotal (Lps)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $factura->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($detalle->nombre); ?></td>
                            <td><?php echo e($detalle->categoria ?? 'N/A'); ?></td>
                            <td><?php echo e(number_format($detalle->precio_venta, 2)); ?></td>
                            <td><?php echo e($detalle->cantidad); ?></td>
                            <td><?php echo e($detalle->iva); ?>%</td>
                            <td><?php echo e(number_format($detalle->subtotal, 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-muted fst-italic py-3">No hay productos registrados en esta factura.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-md-6 col-lg-5">
                    <div class="totales-card">
                        <div class="totales-row">
                            <span>Importe Gravado (Lps):</span>
                            <span><?php echo e(number_format($factura->importe_gravado, 2)); ?></span>
                        </div>
                        <div class="totales-row">
                            <span>Importe Exento (Lps):</span>
                            <span><?php echo e(number_format($factura->importe_exento, 2)); ?></span>
                        </div>
                        <div class="totales-row">
                            <span>Importe Exonerado (Lps):</span>
                            <span><?php echo e(number_format($factura->importe_exonerado, 2)); ?></span>
                        </div>
                        <div class="totales-row">
                            <span>Subtotal (Lps):</span>
                            <span><?php echo e(number_format($factura->subtotal, 2)); ?></span>
                        </div>
                        <div class="totales-row">
                            <span>ISV 15% (Lps):</span>
                            <span><?php echo e(number_format($factura->isv_15, 2)); ?></span>
                        </div>
                        <div class="totales-row mb-3">
                            <span>ISV 18% (Lps):</span>
                            <span><?php echo e(number_format($factura->isv_18, 2)); ?></span>
                        </div>
                        <div class="totales-row total">
                            <span>Total Final (Lps):</span>
                            <span><?php echo e(number_format($factura->totalF, 2)); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        Última actualización: <?php echo e($factura->updated_at->diffForHumans()); ?>

    </div>
</div>
<div class="btn-container" style="max-width: 1000px; margin: 1rem auto 2rem auto; text-align: center;">
    <a href="<?php echo e(route('facturas_ventas.index')); ?>" class="btn btn-warning">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/facturas_ventas/show.blade.php ENDPATH**/ ?>