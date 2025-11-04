<?php $__env->startSection('titulo', 'Proveedores'); ?>

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
                Lista de proveedores
            </h3>

            <div class="row mb-4">
                <div class="col d-flex justify-content-start">
                    <div class="w-100" style="max-width: 400px;">
                        <div class="input-group">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="<?php echo e(request('search')); ?>"
                                class="form-control"
                                placeholder="Buscar por nombre, departamento o categoría"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-auto d-flex justify-content-end">
                    <a href="<?php echo e(route('Proveedores.nuevo')); ?>" class="btn btn-sm btn-outline-primary mb-2">
                        <i class="bi bi-pencil-square me-2"></i>Registrar un nuevo proveedor
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
                    <th>N°</th>
                    <th>Nombre de la empresa</th>
                    <th>Departamento</th>
                    <th>Teléfono de la empresa</th>
                    <th>Categoría o rubro</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($proveedor->nombreEmpresa); ?></td>
                        <td><?php echo e($proveedor->departamento); ?></td>
                        <td><?php echo e($proveedor->telefonodeempresa); ?></td>
                        <td><?php echo e($proveedor->categoriarubro); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('Proveedores.detalle', $proveedor->id)); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="<?php echo e(route('Proveedores.edit', $proveedor->id)); ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="bi bi-pencil-square"></i>Editar
                            </a>
                        </td>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hay proveedores registrados.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <?php if(request('search') && $proveedores->total() > 0): ?>
                <div class="mb-3 text-muted">
                    Mostrando <?php echo e($proveedores->count()); ?> de <?php echo e($proveedores->total()); ?> resultados encontrados para
                    "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php elseif(request('search') && $proveedores->total() === 0): ?>
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($proveedores->links('pagination::bootstrap-5')); ?>



            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');

            if (searchInput.value !== '') {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }

            let timeout = null;

            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    const search = this.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', search);
                    window.location.href = url.toString();
                }, 0.5);
            });
        });

    </script>







<?php $__env->stopSection(); ?>










<?php echo $__env->make("plantilla", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesig\Herd\sistemadeseguridadcentinela\resources\views/Proveedores/indexProveedor.blade.php ENDPATH**/ ?>