<?php $__env->startSection('content'); ?>
    <style>
        .tabla-descuentos td {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }

        .descuento-expirado {
            background-color: #ffe6e6 !important;
        }
    </style>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-percent me-2"></i>Lista de descuentos
            </h3>

            <form method="GET" action="<?php echo e(route('descuentos.index')); ?>">
                <div class="row mb-4 align-items-center">

                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                   placeholder="Buscar nombre de descuento..."
                                   value="<?php echo e(request('search')); ?>">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

    

    <div class="col-md-2">
        <div class="input-group input-group-sm">
            <span class="input-group-text">Tipo</span>
            <select name="tipo" id="tipoSelect" class="form-select">
                <option value="">Todos</option>
                <option value="porcentaje" <?php echo e(request('tipo') == 'porcentaje' ? 'selected' : ''); ?>>Porcentaje</option>
                <option value="fijo" <?php echo e(request('tipo') == 'fijo' ? 'selected' : ''); ?>>Fijo</option>
            </select>
        </div>
    </div>

    <div class="col-md-3 d-flex flex-column gap-2">
        <div class="input-group input-group-sm">
            <span class="input-group-text">Desde</span>
            <input type="date" name="fecha_inicio" class="form-control"
                   style="min-width: 160px;"
                   value="<?php echo e(request('fecha_inicio')); ?>">
        </div>
        <div class="input-group input-group-sm">
            <span class="input-group-text">Hasta</span>
            <input type="date" name="fecha_fin" class="form-control"
                   style="min-width: 160px;"
                   value="<?php echo e(request('fecha_fin')); ?>">
        </div>
    </div>

    <div class="col-md-2 d-flex flex-column gap-2 align-items-start">
        <button type="submit" class="btn btn-sm btn-primary px-2 py-1" style="font-size: 12px; width: 90px;">
            <i class="bi bi-funnel me-1"></i> Filtrar
        </button>
        <a href="<?php echo e(route('descuentos.index')); ?>" class="btn btn-sm btn-secondary px-2 py-1" style="font-size: 12px; width: 90px;">
            <i class="bi bi-x-circle me-1"></i> Limpiar
        </a>
    </div>

    <div class="col-md-2 ms-auto">
        <a href="<?php echo e(route('descuentos.create')); ?>" class="btn btn-md btn-outline-primary w-100">
            <i class="bi bi-pencil-square me-0"></i> Registrar nuevo descuento
        </a>
    </div>
</div>
</form>

<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
<?php endif; ?>

<div class="table-responsive">
<table class="table table-bordered table-striped tabla-descuentos align-middle">
    <thead class="table-dark">
    <tr>
        <th>#</th>
        <th>Nombre del descuento</th>
        <th>Tipo</th>
        <th>Valor</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Activo</th>
        <th class="text-center">Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $descuentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $descuento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $hoy = \Carbon\Carbon::now();
            $inicio = \Carbon\Carbon::parse($descuento->fecha_inicio);
            $fin = \Carbon\Carbon::parse($descuento->fecha_fin)->endOfDay();
            $esActivo = $hoy->between($inicio, $fin);
        ?>

        <tr class="<?php echo e(!$esActivo ? 'descuento-expirado' : ''); ?>">
            <td><?php echo e($loop->iteration + ($descuentos->currentPage() - 1) * $descuentos->perPage()); ?></td>
            <td><?php echo e($descuento->nombre); ?></td>
            <td><?php echo e(ucfirst($descuento->tipo)); ?></td>
            <td>
                <?php if($descuento->tipo == 'porcentaje'): ?>
                    <?php echo e($descuento->valor); ?>%
                <?php else: ?>
                    L <?php echo e(number_format($descuento->valor, 2)); ?>

                <?php endif; ?>
            </td>
            <td><?php echo e($inicio->format('d/m/Y')); ?></td>
            <td><?php echo e($fin->format('d/m/Y')); ?></td>
            <td class="text-center">
                <?php if($esActivo): ?>
                    <span class="badge bg-success">Sí</span>
                <?php else: ?>
                    <span class="badge bg-danger">No</span>
                <?php endif; ?>
            </td>
            <td class="text-center">
                <a href="<?php echo e(route('descuentos.show', $descuento->id)); ?>" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-eye"></i> Ver
                </a>
                <a href="<?php echo e(route('descuentos.edit', $descuento->id)); ?>" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pencil-fill"></i> Editar
                </a>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="8" class="text-center text-muted">No hay descuentos registrados.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

<?php
$filtrosAplicados = request()->filled('search') || request()->filled('activo') || request()->filled('tipo') || request()->filled('fecha_inicio') || request()->filled('fecha_fin');
$filtros = [];
if(request('search')) $filtros[] = 'Nombre: "'.request('search').'"';
if(request('activo') !== null && request('activo') !== '') $filtros[] = 'Activo: '.(request('activo') == '1' ? 'Sí' : 'No');
if(request('tipo')) $filtros[] = 'Tipo: '.ucfirst(request('tipo'));
if(request('fecha_inicio')) $filtros[] = 'Desde: '.\Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y');
if(request('fecha_fin')) $filtros[] = 'Hasta: '.\Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y');
?>

<?php if($filtrosAplicados && $descuentos->total() > 0): ?>
<div class="mb-3 text-muted">
    Mostrando <?php echo e($descuentos->count()); ?> de <?php echo e($descuentos->total()); ?> descuentos encontrados para
    "<strong><?php echo e(implode(', ', $filtros)); ?></strong>".
</div>
<?php elseif($filtrosAplicados && $descuentos->total() === 0): ?>
<div class="mb-3 text-danger">
    No se encontraron resultados para "<strong><?php echo e(implode(', ', $filtros)); ?></strong>".
</div>
<?php endif; ?>

<div class="d-flex justify-content-center mt-4">
<?php echo e($descuentos->links('pagination::bootstrap-5')); ?>

</div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
const searchInput = document.getElementById('searchInput');
const activoSelect = document.getElementById('activoSelect');
const tipoSelect = document.getElementById('tipoSelect');

if (searchInput) {
searchInput.focus();
const length = searchInput.value.length;
searchInput.setSelectionRange(length, length);
}

let timer;
if (searchInput) {
searchInput.addEventListener('input', function () {
    clearTimeout(timer);
    timer = setTimeout(() => {
        const form = searchInput.closest('form');
        form.submit();
    }, 500);
});
}

[activoSelect, tipoSelect].forEach(select => {
if (select) {
    select.addEventListener('change', function () {
        this.closest('form').submit();
    });
}
});
});
</script>
</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/descuentos/index.blade.php ENDPATH**/ ?>