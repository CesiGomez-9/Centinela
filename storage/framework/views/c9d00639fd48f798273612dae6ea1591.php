<!-- resources/views/instalaciones/partials/detalle.blade.php -->
<div class="row g-3">
    <div class="col-md-6">
        <p><i class="bi bi-person-badge me-2"></i><strong>Cliente:</strong> <?php echo e($instalacion->cliente->nombre); ?></p>
        <p><i class="bi bi-tools me-2"></i><strong>Servicio:</strong> <?php echo e($instalacion->servicio->nombre); ?></p>
        <p><i class="bi bi-calendar-event me-2"></i><strong>Fecha:</strong> <?php echo e($instalacion->fecha_instalacion); ?></p>
        <p><i class="bi bi-geo-alt me-2"></i><strong>Dirección:</strong> <?php echo e($instalacion->direccion); ?></p>
    </div>
    <div class="col-md-6">
        <p><i class="bi bi-cash-coin me-2"></i><strong>Costo:</strong> L. <?php echo e($instalacion->costo_instalacion); ?></p>
        <p><i class="bi bi-people me-2"></i><strong>Técnicos:</strong>
        <ul>
            <?php $__currentLoopData = $instalacion->empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($empleado->nombre); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        </p>
        <p><i class="bi bi-receipt me-2"></i><strong>Factura:</strong> <?php echo e($instalacion->factura_id ?? 'No aplica'); ?></p>
    </div>
    <div class="col-12">
        <p><i class="bi bi-file-text me-2"></i><strong>Descripción:</strong> <?php echo e($instalacion->descripcion); ?></p>
    </div>
</div>
<?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/instalaciones/detalle.blade.php ENDPATH**/ ?>