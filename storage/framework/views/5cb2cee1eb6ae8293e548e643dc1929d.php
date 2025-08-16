<?php $__env->startSection('titulo', 'Turnos'); ?>
<?php $__env->startSection('content'); ?>
    <style>
        body {
            background-color: #e6f0ff;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
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

        .form-control {
            border-radius: 0.5rem;
        }

        .input-group-text {
            border-radius: 0.5rem 0 0 0.5rem;
        }

        /* Ajuste para los campos de fecha */
        .input-group.input-group-sm .form-control {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>

    <div class="container mt-5 mb-5" style="max-width: 1100px;">
        
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
                <i class="bi bi-calendar-check-fill me-2"></i>
                Listado de asignación de turnos
            </h3>

            
            <form action="<?php echo e(route('turnos.index')); ?>" method="GET" id="filterForm">
                <div class="row mb-4 align-items-start">
                    
                    <div class="col-lg-5 col-md-12 mb-3">
                        <div class="input-group">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="<?php echo e(request('search')); ?>"
                                class="form-control"
                                maxlength="30"
                                placeholder="Buscar por cliente o servicio"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    
                    <div class="col-lg-4 col-md-12 mb-3 d-flex align-items-center">
                        <div class="d-flex flex-column me-2">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Desde</span>
                                <input type="date" name="fecha_inicio" id="fechaInicio" class="form-control"
                                       value="<?php echo e(request('fecha_inicio')); ?>">
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Hasta</span>
                                <input type="date" name="fecha_fin" id="fechaFin" class="form-control"
                                       value="<?php echo e(request('fecha_fin')); ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary mt-2">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                    </div>

                    
                    <div class="col-lg-3 col-md-12 mb-3">
                        <a href="<?php echo e(route('turnos.create')); ?>" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-plus-circle me-2"></i>Asignar un servicio
                        </a>
                    </div>
                </div>

                
                <div class="row mb-4">
                    <div class="col-12 d-flex justify-content-end">
                        <?php if(request()->filled('search') || request()->filled('fecha_inicio') || request()->filled('fecha_fin')): ?>
                            <a href="<?php echo e(route('turnos.index')); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Limpiar Filtros
                            </a>
                        <?php endif; ?>
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
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($turno->cliente->nombre); ?> <?php echo e($turno->cliente->apellido); ?></td>
                            <td><?php echo e($turno->servicio->nombre); ?>}</td>
                            <td><?php echo e(\Carbon\Carbon::parse($turno->fecha_inicio)->format('d/m/Y')); ?></td>
                            <td class="text-center">
                                <a href="<?php echo e(route('turnos.show', $turno->id)); ?>" class="btn btn-sm btn-outline-info" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('turnos.edit', $turno->id)); ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
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
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const filterForm = document.getElementById('filterForm');
            let timeout = null;

            // Restablecer el foco en el campo de búsqueda si ya tiene un valor
            if (searchInput.value !== '') {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }

            // Evento para el input de búsqueda con un pequeño retraso para evitar recargas excesivas
            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 500);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("plantilla", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/turnos/index.blade.php ENDPATH**/ ?>