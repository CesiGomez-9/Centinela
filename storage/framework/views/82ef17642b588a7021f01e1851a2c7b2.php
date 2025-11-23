<?php $__env->startSection('content'); ?>
    <style>
        body {
            background-color: #e6f0ff;
            min-height: 100vh;
            margin: 0;
        }


        .btn-outline-custom {
            border: 2px solid #09457f;
            background-color: transparent;
            color: #09457f;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background-color: #09457f;
            color: white;
        }

        /* --- Estilo compacto para la tabla --- */
        .table {
            font-size: 1.0rem; /* texto más pequeño */
            margin-bottom: 0;
        }

        .table th, .table td {
            padding: 0.5rem 0.75rem; /* menos espacio */
            vertical-align: middle; /* centra verticalmente */
        }

        .table thead th {
            background-color: #0d1b2a !important;
            color: #ffffff;
            font-weight: 600;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f5f8ff;
        }

        .table-bordered {
            border: 1px solid #bcd0e4;
        }

        /* Compactar botones dentro de la tabla */
        .table .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        /* Contenedor más angosto */
        .container {
            max-width: 1000px; /* antes 1100px */
        }

        /* Tarjeta más compacta */
        .card {
            padding: 1.5rem !important;
        }

        /* Espaciado reducido entre secciones */
        h3 {
            font-size: 1.4rem;
        }

        .input-group input {
            font-size: 0.9rem;
        }

        /* Botón superior más pequeño */
        .btn-outline-primary {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
        }
    </style>

    <div class="container mt-5">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-journal-check me-2"></i>
                Lista de asistencias
            </h3>

            <div class="row mb-3">
                <div class="col d-flex justify-content-between align-items-center">
                    <!-- Buscador -->
                    <div style="max-width: 350px; width: 100%;">
                        <div class="input-group">
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="<?php echo e(request('search')); ?>"
                                class="form-control"
                                placeholder="Buscar por nombre, apellido o identidad"
                            >
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                    </div>

                    <!-- Botón -->
                    <a href="<?php echo e(route('asistencias.crear')); ?>" class="btn btn-outline-primary mb-2">
                        <i class="bi bi-arrow-left-circle me-1"></i>Control de asistencia
                    </a>
                </div>
            </div>

            <?php if(session('exito')): ?>
                <div class="alert alert-success alert-dismissible fade show py-2" role="alert" style="font-size: 0.9rem;">
                    <?php echo e(session('exito')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show py-2" role="alert" style="font-size: 0.9rem;">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <table class="table table-bordered table-striped table-sm align-middle">
                <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Hora de entrada</th>
                    <th>Hora de salida</th>
                    <th class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $asistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asistencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($asistencia->nombre); ?></td>
                        <td><?php echo e($asistencia->created_at ? $asistencia->created_at->format('d/m/Y') : '-'); ?></td>
                        <td><?php echo e($asistencia->hora_entrada ? $asistencia->hora_entrada->format('h:i A') : '-'); ?></td>
                        <td><?php echo e($asistencia->hora_salida ? $asistencia->hora_salida->format('h:i A') : 'No marcada'); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('asistencias.show', $asistencia->id)); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                <?php echo e($asistencias->links('pagination::bootstrap-5')); ?>

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
                    url.searchParams.set('search', search);
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                }, 750);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/asistencias/index.blade.php ENDPATH**/ ?>