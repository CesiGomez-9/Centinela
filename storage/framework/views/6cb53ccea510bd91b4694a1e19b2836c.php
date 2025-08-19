<?php $__env->startSection('content'); ?>

<div class="container mt-5" style="max-width: 1100px;">
    <div class="card shadow p-4" style="background-color: #ffffff;">
        <h3 class="text-center mb-4" style="color: #09457f;">
            <i class="bi bi-people-fill me-2"></i>
            Lista de empleados
        </h3>

        <div class="row mb-4 align-items-center">
            <div class="col-md-6 d-flex justify-content-start">
                <div class="w-100" style="max-width: 400px;">
                    <form method="GET" action="<?php echo e(route('empleados.index')); ?>">
                        <div class="input-group">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="<?php echo e(request('search')); ?>"
                                class="form-control"
                                placeholder="Buscar por nombre, departamento o identidad"
                                autocomplete="off"
                            />
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a href="<?php echo e(route('empleados.create')); ?>" class="btn btn-md btn-outline-primary">
                    <i class="bi bi-pencil-square me-2"></i>Registrar un nuevo empleado
                </a>
            </div>
        </div>

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
                <th>#</th>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($empleados->firstItem() + $loop->index); ?></td>
                    <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                        <?php echo e($empleado->nombre); ?> <?php echo e($empleado->apellido); ?></td>
                    <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                        <?php echo e($empleado->departamento); ?></td>
                    <td><?php echo e($empleado->telefono); ?></td>
                    <td class="text-center">
                        <a href="<?php echo e(route('empleados.show', $empleado->id)); ?>" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="<?php echo e(route('empleados.edit', $empleado->id)); ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                            <i class="bi bi-pencil-square"></i>Editar
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay empleados registrados.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <?php if(request('search') && $empleados->total() > 0): ?>
            <div class="mb-3 text-muted">
                Mostrando <?php echo e($empleados->count()); ?> de <?php echo e($empleados->total()); ?> empleados encontrados para
                "<strong><?php echo e(request('search')); ?></strong>".
            </div>
        <?php elseif(request('search') && $empleados->total() === 0): ?>
            <div class="mb-3 text-danger">
                No se encontraron resultados para "<strong><?php echo e(request('search')); ?></strong>".
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center mt-4">
            <?php echo e($empleados->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>

<?php if($errors->any()): ?>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const form = searchInput.closest('form');

        if (searchInput) {
            searchInput.focus();
            const length = searchInput.value.length;
            searchInput.setSelectionRange(length, length);
        }

        if (form) {
            form.addEventListener('submit', e => e.preventDefault());
        }
        searchInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') e.preventDefault();
        });

        let timeout = null;

        searchInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, "");
            this.value = this.value.replace(/\s+/g, " ");

            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const search = this.value;
                const url = new URL(window.location.href);

                if (search.trim() !== "") {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }

                window.location.href = url.toString();
            }, 500);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/empleados/index.blade.php ENDPATH**/ ?>