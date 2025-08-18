<?php $__env->startSection('titulo', 'Venta servicios'); ?>
<?php $__env->startSection('content'); ?>
    <style>
        body {
            background-color: #e6f0ff;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .table-black-header th {
            background-color: #000000;
            color: #ffffff;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .table-striped tbody tr:hover {
            background-color: #e2f2ff;
        }

        .btn-outline-info, .btn-outline-warning {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-outline-primary, .btn-primary {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .btn-smaller-font {
            font-size: 0.85rem;
        }

        .btn-extra-small {
            padding: 0.2rem 0.5rem;
            font-size: 0.8rem;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .input-group-text {
            border-radius: 0.5rem 0 0 0.5rem;
        }

        .date-input-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-grow: 1;
        }

        .date-input-container .form-control {
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
        }
    </style>

    <div class="container my-5" style="max-width: 1100px;">
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

        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-calendar-check-fill me-2"></i> Listado de venta de servicios
            </h3>

            <form method="GET" action="<?php echo e(route('turnos.index')); ?>" id="filterForm" autocomplete="off">
                <div class="row mb-4 g-2 d-flex flex-wrap align-items-start">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                class="form-control"
                                maxlength="50"
                                placeholder="Buscar por cliente o servicio..."
                                value="<?php echo e(request('search')); ?>"
                                onkeypress="return validarTexto(event)">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-3 ms-4 d-flex flex-column gap-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Desde</span>
                            <input type="date" name="fecha_inicio" id="fechaInicio" class="form-control" value="<?php echo e(request('fecha_inicio')); ?>">
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Hasta</span>
                            <input type="date" name="fecha_fin" id="fechaFin" class="form-control" value="<?php echo e(request('fecha_fin')); ?>">
                        </div>
                    </div>
                    <div class="col-md-1 ms-2 d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-sm btn-primary btn-extra-small">
                            <i class="bi bi-funnel"></i> Filtrar
                        </button>
                        <a href="<?php echo e(route('turnos.index')); ?>" class="btn btn-sm btn-secondary btn-extra-small">
                            <i class="bi bi-x-circle"></i> Limpiar
                        </a>
                    </div>
                    <div class="col-md-3 ms-5">
                        <a href="<?php echo e(route('turnos.create')); ?>"  class="btn btn-md btn-outline-primary w-80 btn-smaller-font">
                            <i class="bi bi-pencil-square me-1"></i>Venta de servicio
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

            
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-black-header">
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Fecha inicio</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $turnos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(($turnos->currentPage() - 1) * $turnos->perPage() + $loop->iteration); ?></td>
                            <td><?php echo e($turno->cliente->nombre); ?> <?php echo e($turno->cliente->apellido); ?></td>
                            <td><?php echo e($turno->servicio->nombre); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($turno->fecha_inicio)->format('d/m/Y')); ?></td>
                            <td class="text-center">
                                <a href="<?php echo e(route('turnos.show', $turno->id)); ?>" class="btn btn-sm btn-outline-info" title="Ver detalle">
                                    <i class="bi bi-eye"> Ver</i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No hay turnos registrados.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(request('search') || request('fecha_inicio') || request('fecha_fin')): ?>
                <div class="mb-3 text-muted">
                    Mostrando <?php echo e($turnos->count()); ?> de <?php echo e($turnos->total()); ?> resultados encontrados.
                </div>
                <?php if($turnos->total() === 0): ?>
                    <div class="mb-3 text-danger">
                        No se encontraron resultados para los filtros aplicados.
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($turnos->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>

    <script>
        function validarTexto(e) {
            const key   = e.keyCode || e.which;
            const char  = String.fromCharCode(key);
            const input = e.target;
            const pos   = input.selectionStart;
            if (pos === 0 && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ]$/.test(char)) {
                e.preventDefault();
                return false;
            }
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }
            if (key === 32) {
                const pos = input.selectionStart;
                if (input.value.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const filterForm = document.getElementById('filterForm');
            let timeout = null;

            if (searchInput.value) {
                searchInput.focus();
                searchInput.selectionStart = searchInput.selectionEnd = searchInput.value.length;
            }

            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 450);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("plantilla", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/turnos/index.blade.php ENDPATH**/ ?>