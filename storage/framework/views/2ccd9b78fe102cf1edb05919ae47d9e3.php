<?php $__env->startSection('content'); ?>

    <style>
        body{
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }
    </style>

    <?php if(session('exito')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('exito')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <?php if(session('fracaso')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('fracaso')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>
                Lista de incidencias
            </h3>

            <form method="GET" action="<?php echo e(route('incidencias.index')); ?>">
                <div class="row mb-4 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="<?php echo e(request('search')); ?>"
                                class="form-control"
                                placeholder="Buscar por reportado, tipo, cliente, estado"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex flex-column gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Desde</span>
                            <input
                                type="date"
                                name="fecha_inicio"
                                class="form-control"
                                value="<?php echo e(request('fecha_inicio')); ?>"
                            >
                        </div>
                        <div class="input-group input-group-sm w-100">
                            <span class="input-group-text">Hasta</span>
                            <input
                                type="date"
                                name="fecha_fin"
                                class="form-control"
                                value="<?php echo e(request('fecha_fin')); ?>"
                            >
                        </div>
                    </div>

                    <div class="col-md-2 ms-3 d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <a href="<?php echo e(route('incidencias.index')); ?>" class="btn btn-sm btn-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i> Limpiar
                        </a>
                    </div>

                    <div class="col-auto d-flex justify-content-end">
                        <a href="<?php echo e(route('incidencias.formulario')); ?>" class="btn btn-sm btn-outline-primary mb-2">
                            <i class="bi bi-pencil-square me-2"></i>Registrar una nueva incidencia
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

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Reportado por</th>
                    <th>Tipo</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $incidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($incidencia->reportadoPorEmpleado->nombre ?? '---'); ?></td>
                        <td><?php echo e($incidencia->tipo); ?></td>
                        <td><?php echo e($incidencia->cliente->nombre ?? '---'); ?> </td>
                        <td><?php echo e($incidencia->estado); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y')); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('incidencias.detalle', $incidencia->id)); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="<?php echo e(route('incidencias.edit', $incidencia->id)); ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="bi bi-pencil-square"></i>Editar
                            </a>

                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay incidencias registradas.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <?php if(request('search') && $incidencias->total() > 0): ?>
                <div class="mb-3 text-muted">
                    Mostrando <?php echo e($incidencias->count()); ?> de <?php echo e($incidencias->total()); ?> resultados encontrados para
                    "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php elseif(request('search') && $incidencias->total() === 0): ?>
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($incidencias->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;

            searchInput.focus();
            const length = searchInput.value.length;
            searchInput.setSelectionRange(length, length);

            let timer;
            searchInput.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    const form = searchInput.closest('form');
                    form.submit();
                }, 500);
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("plantilla", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/incidencias/index.blade.php ENDPATH**/ ?>