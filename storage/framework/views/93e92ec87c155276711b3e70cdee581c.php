<?php $__env->startSection('content'); ?>
    <style>
        .tabla-incapacidades td {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }

        .incapacidad-finalizada {
            background-color: #ffe6e6 !important;
        }
    </style>

    <body style="background-color: #e6f0ff;">
    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-file-earmark-medical me-2"></i>Lista de incapacidades
            </h3>

            <form method="GET" action="<?php echo e(route('incapacidades.index')); ?>" id="filtroForm" class="mb-4 row align-items-end">

                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Buscar empleado..."
                               value="<?php echo e(request('search')); ?>">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Estado</span>
                        <select name="estado" id="estadoSelect" class="form-select">
                            <option value="">Todos...</option>
                            <option value="vigente" <?php echo e(request('estado') == 'vigente' ? 'selected' : ''); ?>>Vigente</option>
                            <option value="finalizado" <?php echo e(request('estado') == 'finalizado' ? 'selected' : ''); ?>>Finalizado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 d-flex flex-column gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Desde</span>
                        <input type="date" name="fecha_inicio" class="form-control"
                               value="<?php echo e(request('fecha_inicio')); ?>">
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Hasta</span>
                        <input type="date" name="fecha_fin" class="form-control"
                               value="<?php echo e(request('fecha_fin')); ?>">
                    </div>
                </div>

                <div class="col-md-2 d-flex flex-column gap-2 align-items-start">
                    <button type="submit" class="btn btn-sm btn-primary px-2 py-1">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <a href="<?php echo e(route('incapacidades.index')); ?>" class="btn btn-sm btn-secondary px-2 py-1">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>

                <div class="col-md-2 ms-auto">
                    <a href="<?php echo e(route('incapacidades.create')); ?>" class="btn btn-md btn-outline-primary w-100">
                        <i class="bi bi-pencil-square me-1"></i> Registrar incapacidad
                    </a>
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
                <table class="table table-bordered table-striped tabla-incapacidades align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Empleado</th>
                        <th>Motivo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $incapacidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incapacidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $hoy = now()->toDateString();
                            $estado = ($incapacidad->fecha_fin < $hoy) ? 'Finalizado' : 'Vigente';
                        ?>
                        <tr class="<?php echo e($estado == 'Finalizado' ? 'incapacidad-finalizada' : ''); ?>">
                            <td><?php echo e($loop->iteration + ($incapacidades->currentPage() - 1) * $incapacidades->perPage()); ?></td>
                            <td><?php echo e($incapacidad->empleado->nombre); ?> <?php echo e($incapacidad->empleado->apellido); ?></td>
                            <td><?php echo e($incapacidad->motivo); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($incapacidad->fecha_inicio)->format('d/m/Y')); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($incapacidad->fecha_fin)->format('d/m/Y')); ?></td>
                            <td class="text-center">
                            <span class="badge <?php echo e($estado == 'Vigente' ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($estado); ?>

                            </span>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(route('incapacidades.show', $incapacidad->id)); ?>" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="<?php echo e(route('incapacidades.edit', $incapacidad->id)); ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay incapacidades registradas.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php
                    $filtrosAplicados = request()->filled('search') || request()->filled('estado') || request()->filled('fecha_inicio') || request()->filled('fecha_fin');
                ?>

                <?php if($filtrosAplicados && $incapacidades->total() > 0): ?>
                    <div class="mb-3 text-muted">
                        Mostrando <?php echo e($incapacidades->count()); ?> de <?php echo e($incapacidades->total()); ?> incapacidades encontradas
                        <?php if(request('search') || request('estado') || request('fecha_inicio') || request('fecha_fin')): ?>
                            para
                            <?php
                                $filtros = [];
                                if(request('search')) $filtros[] = 'Empleado: "'.request('search').'"';
                                if(request('estado')) $filtros[] = 'Estado: "'.ucfirst(request('estado')).'"';
                                if(request('fecha_inicio') || request('fecha_fin')) {
                                    $fechas = [];
                                    if(request('fecha_inicio')) $fechas[] = 'desde '.\Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y');
                                    if(request('fecha_fin')) $fechas[] = 'hasta '.\Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y');
                                    $filtros[] = 'Fechas: '.implode(' ', $fechas);
                                }
                            ?>
                            "<strong><?php echo e(implode(', ', $filtros)); ?></strong>"
                        <?php endif; ?>
                    </div>
                <?php elseif($filtrosAplicados && $incapacidades->total() === 0): ?>
                    <div class="mb-3 text-danger">
                        No se encontraron resultados
                        <?php if(request('search')): ?> para "<strong><?php echo e(request('search')); ?></strong>" <?php endif; ?>
                        <?php if(request('estado')): ?> con estado "<strong><?php echo e(ucfirst(request('estado'))); ?></strong>" <?php endif; ?>
                        <?php if(request('fecha_inicio') || request('fecha_fin')): ?> en fechas
                        <?php if(request('fecha_inicio')): ?> desde <strong><?php echo e(\Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y')); ?></strong> <?php endif; ?>
                        <?php if(request('fecha_fin')): ?> hasta <strong><?php echo e(\Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y')); ?></strong> <?php endif; ?>
                        <?php endif; ?>.
                    </div>
                <?php endif; ?>

            </div>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($incapacidades->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const estadoSelect = document.getElementById('estadoSelect');
            const filtroForm = document.getElementById('filtroForm');

            if (searchInput) {
                searchInput.focus();
                const length = searchInput.value.length;
                searchInput.setSelectionRange(length, length);

                let timer;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        filtroForm.submit();
                    }, 500);
                });
            }

            if (estadoSelect) {
                estadoSelect.addEventListener('change', function () {
                    filtroForm.submit();
                });
            }
        });
    </script>
    </body>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/incapacidades/index.blade.php ENDPATH**/ ?>