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
                Lista de clientes
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
                                placeholder="Buscar por nombre, identidad, departamento"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-auto d-flex justify-content-end">
                    <a href="<?php echo e(route('Clientes.formulariocliente')); ?>" class="btn btn-sm btn-outline-primary mb-2">
                        <i class="bi bi-pencil-square me-2"></i>Registrar un nuevo cliente
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
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Identidad</th>
                    <th>Departamento</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($cliente->nombre); ?></td>
                        <td><?php echo e($cliente->apellido); ?></td>
                        <td><?php echo e($cliente->identidad); ?></td>
                        <td><?php echo e($cliente->departamento); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('Clientes.detalleCliente', $cliente->id)); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="<?php echo e(route('Clientes.edit', $cliente->id)); ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="bi bi-pencil-square"></i>Editar
                            </a>

                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hay clientes registrados.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>

            <?php if(request('search') && $clientes->total() > 0): ?>
                <div class="mb-3 text-muted">
                    Mostrando <?php echo e($clientes->count()); ?> de <?php echo e($clientes->total()); ?> resultados encontrados para
                    "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php elseif(request('search') && $clientes->total() === 0): ?>
                <div class="mb-3 text-danger">
                    No se encontraron resultados para "<strong><?php echo e(request('search')); ?></strong>".
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-center mt-4">
                <?php echo e($clientes->links('pagination::bootstrap-5')); ?>



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
                    const search = this.value.trim();

                    const url = new URL(window.location.href);
                    url.searchParams.set('search', search); // ✅ deja espacios, los codifica automáticamente
                    url.searchParams.delete('page'); // ✅ reinicia a la página 1

                    window.location.href = url.toString();
                }, 750); // ⏱️ Espera 800ms para que puedas escribir tranquilo
            });
        });
    </script>





<?php $__env->stopSection(); ?>

<?php echo $__env->make("plantilla", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/Clientes/indexCliente.blade.php ENDPATH**/ ?>