<?php $__env->startSection('content'); ?>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-people-fill me-2"></i>
                Lista de usuarios
            </h3>

            <div class="row mb-4 align-items-center">
                <div class="col-md-6 d-flex justify-content-start">
                    <div class="w-100" style="max-width: 400px;">
                        <form method="GET" action="<?php echo e(route('users.index')); ?>">
                            <div class="input-group">
                                <input
                                    type="text"
                                    id="searchInput"
                                    name="search"
                                    value="<?php echo e(request('search')); ?>"
                                    class="form-control"
                                    placeholder="Buscar por nombre o usuario..."
                                    autocomplete="off"
                                />
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-md btn-outline-primary">
                        <i class="bi bi-pencil-square me-2"></i>Registrar nuevo usuario
                    </a>
                </div>
            </div>

            <?php if(session('mensaje')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo e(session('mensaje')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Teléfono</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($users->firstItem() + $loop->index); ?></td>
                        <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                            <?php echo e($user->name); ?> <?php echo e($user->apellido); ?>

                        </td>
                        <td><?php echo e($user->usuario ?? '—'); ?></td>
                        <td><?php echo e($user->telefono ?? '—'); ?></td>
                        <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('users.show', $user->id)); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <?php if(request('search') && $users->total() > 0): ?>
                <div class="mb-3 text-muted">
                    Mostrando <?php echo e($users->count()); ?> de <?php echo e($users->total()); ?> usuarios encontrados para
                    "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php elseif(request('search') && $users->total() === 0): ?>
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($users->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>

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


<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/users/index.blade.php ENDPATH**/ ?>