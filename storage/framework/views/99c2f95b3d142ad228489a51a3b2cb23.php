<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Incidencias</title>
    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #0d1b2a;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #caa23b;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .logo {
            height: 60px;
        }

        .empresa-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .empresa-info .nombre {
            font-size: 20px;
            font-weight: bold;
            color: #0d1b2a;
        }

        .empresa-info .subtitulo {
            font-size: 14px;
            color: #caa23b;
        }

        .titulo-reporte {
            text-align: center;
            font-size: 18px;
            margin: 20px 0;
            border-bottom: 1px solid #caa23b;
            padding-bottom: 5px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #0d1b2a;
            color: #fff;
            font-weight: bold;
            text-align: left;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px 6px;
            vertical-align: top;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }

        .firma {
            margin-top: 60px;
            border-top: 1px solid #0d1b2a;
            width: 200px;
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    
    <img src="<?php echo e(public_path('centinela.jpg')); ?>" alt="Logo" class="logo">

    <div class="empresa-info">
        <div class="nombre">Grupo de seguridad Centinela</div>
        <div class="subtitulo">Reporte de Incidencias</div>
        <div><?php echo e(now()->format('d/m/Y')); ?></div>
    </div>
</header>

<div class="titulo-reporte">
    Listado de Incidencias
</div>



<div class="filtros">
    <strong>Filtros aplicados:</strong><br>

    <?php if(isset($filtrosAplicados['fecha_inicio']) || isset($filtrosAplicados['fecha_fin'])): ?>
        <strong>Rango de fechas:</strong>
        <?php echo e($filtrosAplicados['fecha_inicio'] ?? '---'); ?> hasta <?php echo e($filtrosAplicados['fecha_fin'] ?? '---'); ?><br>
    <?php endif; ?>

    <?php if(isset($filtrosAplicados['reportado_por'])): ?>
        <strong>Reportado por:</strong> <?php echo e($filtrosAplicados['reportado_por']); ?><br>
    <?php endif; ?>

    <?php if(isset($filtrosAplicados['cliente'])): ?>
        <strong>Cliente:</strong> <?php echo e($filtrosAplicados['cliente']); ?><br>
    <?php endif; ?>

    <?php if(isset($filtrosAplicados['tipo'])): ?>
        <strong>Tipo:</strong> <?php echo e($filtrosAplicados['tipo']); ?><br>
    <?php endif; ?>

    <?php if(isset($filtrosAplicados['estado'])): ?>
        <strong>Estado:</strong> <?php echo e($filtrosAplicados['estado']); ?><br>
    <?php endif; ?>

    <?php if(empty($filtrosAplicados)): ?>
        <em>No se aplicaron filtros</em>
    <?php endif; ?>
</div>




<table>
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Cliente Afectado</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Reportado por</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $incidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(\Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y')); ?></td>
            <td><?php echo e($incidencia->cliente->nombre ?? '---'); ?></td>
            <td><?php echo e($incidencia->tipo); ?></td>
            <td><?php echo e($incidencia->descripcion); ?></td>
            <td><?php echo e($incidencia->reportadoPorEmpleado->nombre ?? '---'); ?></td>
            <td><?php echo e(ucfirst($incidencia->estado)); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<div class="footer">
    <div class="firma">
        Firma Responsable<br>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/incidencias/reportepdf.blade.php ENDPATH**/ ?>