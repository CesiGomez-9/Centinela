<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Compra <?php echo e($factura->numero_factura); ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            background: #ffffff;
            color: #333;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #ddd;
        }

        /* HEADER */
        .card-header {
            background-color: #0d1b2a;
            padding: 18px 20px;
            border-bottom: 4px solid #cda34f;
        }
        .card-header h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            text-align: center;
            margin: 0;
        }
        .card-header .fecha-creacion {
            color: #f0e6d2;
            font-size: 10px;
            text-align: right;
            margin-top: 4px;
        }

        /* BODY */
        .card-body {
            padding: 20px;
        }

        /* SECCIÓN PROVEEDOR / DETALLES */
        .info-table {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
            padding: 0;
            width: 50%;
        }

        .info-box {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 14px;
            background: #fdfdfd;
            margin: 0 4px;
        }
        .info-box p {
            font-size: 10px;
            margin-bottom: 4px;
            line-height: 1.5;
        }
        .info-box strong {
            color: #0d1b2a;
            font-weight: 700;
        }

        /* TÍTULO DE SECCIÓN */
        .section-title {
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            color: #0d1b2a;
            border-bottom: 2px solid #cda34f;
            padding-bottom: 5px;
            margin: 16px 0 10px 0;
        }

        /* TABLA DE PRODUCTOS */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 10px;
        }
        .products-table thead th {
            background-color: #f2f2f2;
            font-weight: 700;
            color: #333;
            border-bottom: 2px solid #cda34f;
            padding: 8px 6px;
            text-align: center;
        }
        .products-table tbody td {
            padding: 7px 6px;
            text-align: center;
            border-bottom: 1px solid #eeeeee;
        }
        .products-table tbody tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        /* TOTALES */
        .totals-wrapper {
            width: 100%;
        }
        .totals-box {
            float: right;
            width: 48%;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 14px;
            background: #fdfdfd;
            margin-top: 4px;
        }
        .totals-row {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .totals-row td {
            padding: 4px 0;
        }
        .totals-row td.label { color: #0d1b2a; font-weight: 700; }
        .totals-row td.value { text-align: right; color: #333; }
        .totals-row tr.total-final td {
            border-top: 2px solid #cda34f;
            padding-top: 8px;
            font-size: 11px;
            font-weight: 700;
        }
        .clearfix::after { content: ""; display: table; clear: both; }

        /* FOOTER */
        .card-footer {
            background-color: #1b263b;
            padding: 10px 16px;
            border-top: 1px solid #cda34f;
            text-align: right;
        }
        .card-footer small {
            color: #f5f5f5;
            font-size: 9px;
        }
    </style>
</head>
<body>
<div class="card">

    
    <div class="card-header">
        <h5>&#x1F9FE; Factura de Compra</h5>
        <div class="fecha-creacion">Creado <?php echo e($factura->created_at->diffForHumans()); ?></div>
    </div>

    
    <div class="card-body">

        
        <table class="info-table">
            <tr>
                <td>
                    <div class="info-box">
                        <p><strong>Proveedor:</strong> <?php echo e($factura->proveedor->nombreEmpresa ?? 'N/A'); ?></p>
                        <p><strong>Dirección:</strong> <?php echo e($factura->proveedor->direccion ?? 'N/A'); ?>.</p>
                        <p><strong>Teléfono de la empresa:</strong> <?php echo e($factura->proveedor->telefonodeempresa ?? 'N/A'); ?>.</p>
                        <p><strong>Email:</strong> <?php echo e($factura->proveedor->correoempresa ?? 'N/A'); ?>.</p>
                        <p><strong>Representante:</strong> <?php echo e($factura->proveedor->nombrerepresentante ?? 'N/A'); ?>.</p>
                        <p><strong>Teléfono Representante:</strong> <?php echo e($factura->proveedor->telefonoderepresentante ?? 'N/A'); ?>.</p>
                    </div>
                </td>
                <td>
                    <div class="info-box">
                        <p><strong>Factura de compra N°:</strong> <?php echo e($factura->numero_factura ?? 'N/A'); ?>.</p>
                        <p><strong>Fecha de la factura:</strong> <?php echo e(\Carbon\Carbon::parse($factura->fecha ?? now())->format('d/m/Y')); ?>.</p>
                        <p><strong>Proveedor:</strong> <?php echo e($factura->proveedor->nombreEmpresa ?? 'N/A'); ?></p>
                        <p><strong>Forma de pago:</strong> <?php echo e($factura->forma_pago ?? 'N/A'); ?>.</p>
                        <p><strong>Responsable:</strong> <?php echo e($factura->empleado->nombre ?? 'N/A'); ?> <?php echo e($factura->empleado->apellido ?? 'N/A'); ?>.</p>
                    </div>
                </td>
            </tr>
        </table>

        
        <div class="section-title">Productos comprados</div>

        
        <table class="products-table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Descripción</th>
                    <th>Precio (Lps)</th>
                    <th>Cantidad</th>
                    <th>IVA%</th>
                    <th>Subtotal (Lps)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $factura->detalles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
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
                        <td colspan="6" style="text-align:center; color:#999; font-style:italic; padding:12px;">
                            No hay productos agregados a esta factura.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        
        <div class="totals-wrapper clearfix">
            <div class="totals-box">
                <table class="totals-row">
                    <tr>
                        <td class="label">Importe Gravado (Lps):</td>
                        <td class="value"><?php echo e(number_format($factura->importe_gravado ?? 0, 2)); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Importe Exento (Lps):</td>
                        <td class="value"><?php echo e(number_format($factura->importe_exento ?? 0, 2)); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Importe Exonerado (Lps):</td>
                        <td class="value"><?php echo e(number_format($factura->importe_exonerado ?? 0, 2)); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Subtotal (Lps):</td>
                        <td class="value"><?php echo e(number_format($factura->subtotal ?? 0, 2)); ?></td>
                    </tr>
                    <tr>
                        <td class="label">ISV 15% (Lps):</td>
                        <td class="value"><?php echo e(number_format($factura->isv_15 ?? 0, 2)); ?></td>
                    </tr>
                    <tr>
                        <td class="label">ISV 18% (Lps):</td>
                        <td class="value"><?php echo e(number_format($factura->isv_18 ?? 0, 2)); ?></td>
                    </tr>
                    <tr class="total-final">
                        <td class="label">Total Final (Lps):</td>
                        <td class="value"><?php echo e(number_format($factura->totalF ?? 0, 2)); ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    
    <div class="card-footer">
        <small>Última actualización: <?php echo e($factura->updated_at->diffForHumans()); ?></small>
    </div>

</div>
</body>
</html>
<?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/facturas_compras/pdf.blade.php ENDPATH**/ ?>