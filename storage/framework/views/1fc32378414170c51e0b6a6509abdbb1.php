<?php $__env->startSection('content'); ?>
    <style>
        .tabla-memorandos td {
            max-width: 200px;
            word-wrap: break-word;
            white-space: normal;
        }
    </style>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-file-earmark-text me-2"></i>Lista de memorandum
            </h3>

            <form method="GET" action="<?php echo e(route('memorandos.index')); ?>">
                <div class="row mb-4 align-items-center justify-content-between">

                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" id="searchInput" class="form-control"
                                   placeholder="Buscar por empleado y autor..."
                                   value="<?php echo e(request('search')); ?>">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <label class="input-group-text" for="tipo_memorandum">
                                <i class="bi bi-tags"></i>
                            </label>
                            <select name="tipo_memorandum" id="tipo_memorandum" class="form-select">
                                <option value="">Tipo</option>
                                <option value="Leve" <?php echo e(request('tipo_memorandum') == 'Leve' ? 'selected' : ''); ?>>Leve</option>
                                <option value="Media" <?php echo e(request('tipo_memorandum') == 'Media' ? 'selected' : ''); ?>>Media</option>
                                <option value="Grave" <?php echo e(request('tipo_memorandum') == 'Grave' ? 'selected' : ''); ?>>Grave</option>
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
                        <a href="<?php echo e(route('memorandos.index')); ?>" class="btn btn-sm btn-secondary px-2 py-1" style="font-size: 12px; width: 90px;">
                            <i class="bi bi-x-circle me-1"></i> Limpiar
                        </a>
                    </div>

                    <div class="col-md-2 text-end">
                        <a href="<?php echo e(route('memorandos.create')); ?>" class="btn btn-sm btn-outline-primary" style="font-size: 13px; padding: 4px 8px;">
                            <i class="bi bi-pencil-square me-1"></i> Crear nuevo memorandum
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

            <table class="table table-bordered table-striped tabla-memorandos">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Empleado</th>
                    <th>Autor</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $memorandos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $memorando): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration + ($memorandos->currentPage() - 1) * $memorandos->perPage()); ?></td>
                        <td><?php echo e($memorando->destinatario->nombre ?? '---'); ?> <?php echo e($memorando->destinatario->apellido ?? ''); ?></td>
                        <td><?php echo e($memorando->autor->nombre ?? '---'); ?> <?php echo e($memorando->autor->apellido ?? ''); ?></td>
                        <td><?php echo e($memorando->titulo); ?></td>
                        <td><?php echo e($memorando->tipo); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($memorando->fecha)->format('d/m/Y')); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('memorandos.show', $memorando->id)); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay memorandums registrados.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?php if(request('search') && $memorandos->total() > 0): ?>
                <div class="mb-3 text-muted">
                    Mostrando <?php echo e($memorandos->count()); ?> de <?php echo e($memorandos->total()); ?> memorandums encontrados para
                    "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php elseif(request('search') && $memorandos->total() === 0): ?>
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php endif; ?>


            <div class="d-flex justify-content-center mt-4">
                <?php echo e($memorandos->links('pagination::bootstrap-5')); ?>

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

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/memorandos/index.blade.php ENDPATH**/ ?>