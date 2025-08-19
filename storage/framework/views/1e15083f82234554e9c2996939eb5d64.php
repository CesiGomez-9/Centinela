<?php $__env->startSection('content'); ?>

    <head>
        <meta charset="UTF-8">
        <title>Catálogo de Servicios</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


        <style>
            body {
                background-color: #e6f0ff;
                height: 100vh;
                margin: 0;
                background-color: #f2f4f8;
                font-family: 'Segoe UI', sans-serif;
            }
            .table thead th {
                text-align: center;
                vertical-align: middle;
            }
            .table tbody td {
                vertical-align: middle;
            }
            .navbar-brand {
                display: flex;
                align-items: center;
            }
            .navbar-brand img {
                margin-right: 12px;
            }
            .pagination .page-item.active .page-link {
                background-color: #000 !important;
                border-color: #000 !important;
                color: #fff !important;
            }
            /* Ajuste para la columna de costos */
            .cost-details {
                font-size: 0.9em; /* Ligeramente más pequeño para caber mejor */
                line-height: 1.3; /* Espaciado entre líneas */
            }
            .cost-details strong {
                display: inline-block; /* Asegura que la etiqueta y el valor estén en la misma línea */
                min-width: 45px; /* Alinea las etiquetas */
                text-align: right;
                margin-right: 5px;
            }
        </style>

    </head>






    <body class="bg-light p-4">

    <!-- NAVBAR -->

    <!-- CONTENIDO -->
    <div class="container bg-white p-5 rounded shadow mt-5">

        <!-- Título -->
        <div class="text-center mb-3">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-list-check me-2"></i>Lista de servicios
            </h2>
        </div>

        <!-- Buscador y botón -->
        <div class="d-flex justify-content-between align-items-start mb-5 flex-wrap w-100">
            <!-- Formulario búsqueda -->
            <form method="GET" action="<?php echo e(route('servicios.catalogo')); ?>" style="width: 400px;" class="align-self-start">
                <div class="input-group">
                    <input type="text" id="searchInput" name="search" class="form-control form-control-md"
                           placeholder="Buscar por nombre..." value="<?php echo e(request('search')); ?>">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Botón crear -->
            <a href="<?php echo e(route('servicios.index')); ?>" class="btn btn-outline-primary d-block align-self-start" style="width: 300px;">
                <i class="bi bi-pencil-square me-2"></i> Crear un registro nuevo
            </a>
        </div>

        <!-- Alerta éxito -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <!-- Tabla -->
        <div class="table-responsive mx-auto" style="max-width: 1100px;">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="width: 280px;">Nombre</th>
                    <th style="width: 200px;">Costos</th> 
                    <th style="width: 130px;">Categoría</th>
                    <th style="width: 160px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                        <td class="text-start text-truncate" style="max-width: 280px;"><?php echo e($servicio->nombre); ?></td>
                        <td class="text-start cost-details"> 
                            <div><strong>Diurno:</strong> L. <?php echo e(number_format($servicio->costo_diurno, 2)); ?></div>
                            <div><strong>Nocturno:</strong> L. <?php echo e(number_format($servicio->costo_nocturno, 2)); ?></div>
                            <div><strong>24 horas:</strong> L. <?php echo e(number_format($servicio->costo_24_horas, 2)); ?></div>
                        </td>
                        <td class="text-start"><?php echo e(ucfirst($servicio->categoria)); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('servicios.show', $servicio->id)); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="<?php echo e(route('servicios.edit', $servicio->id)); ?>" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hay servicios registrados.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mensajes búsqueda -->
        <?php if(request('search') && $servicios->total() > 0): ?>
            <div class="mb-3 text-muted">
                Mostrando <?php echo e($servicios->count()); ?> de <?php echo e($servicios->total()); ?> servicios encontrados para
                "<strong><?php echo e(request('search')); ?></strong>".
            </div>
        <?php elseif(request('search') && $servicios->total() === 0): ?>
            <div class="mb-3 text-danger">
                No se encontraron resultados para "<strong><?php echo e(request('search')); ?></strong>".
            </div>
        <?php endif; ?>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($servicios->appends(['search' => request('search')])->links()); ?>

        </div>
    </div>

    <!-- JS búsqueda rápida -->
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
                }, 700);
            });
        });
    </script>

    <!-- Bootstrap JS -->
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/servicios/catalogo.blade.php ENDPATH**/ ?>