<?php $__env->startSection('titulo', 'Listado de productos'); ?>
<?php $__env->startSection('content'); ?>

    <style>
        body{
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }

    </style>

    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
                <i class="bi bi-boxes me-2"></i>Inventario de productos
            </h3>



    <!-- Botón de buscador -->
    <div class="row mb-5 align-items-center">
        <div class="col d-flex justify-content-start">
            <div class="w-100" style="max-width: 350px;">
                <div class="input-group">
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        maxlength="30"

                    placeholder="Buscar por serie"

                    placeholder="Buscar por nombre, serie o código"

                    onkeydown="bloquearEspacioAlInicio(event, this)"
                    oninput="eliminarEspaciosIniciales(this)"
                    >
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <a href="<?php echo e(route('productos.create')); ?>" class="btn btn-sm btn-outline-primary mb-2">
                <i class="bi bi-pencil-square me-2"></i>Registrar un nuevo producto
            </a>
        </div>
    </div>

    <?php if(session()->has('status')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong></strong><?php echo e(session('status')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <!-- Mensaje de resultados -->

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>N°</th> 
                <th>Serie</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="productosTableBody">
            <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="producto-row">
                    <td><?php echo e($loop->iteration); ?></td> 
                    <td><?php echo e($producto->serie); ?></td>
                    <td><?php echo e($producto->codigo); ?></td>
                    <td class="producto-nombre"><?php echo e($producto->nombre); ?></td>
                    <td><?php echo e($producto->marca); ?></td>
                    <td><?php echo e($producto->modelo); ?></td>
                    <td><?php echo e($producto->categoria); ?></td>
                    <td><?php echo e($producto->cantidad); ?></td>
                    <td>
                        <a href="<?php echo e(route('productos.show', $producto->id)); ?>" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-eye"></i>Ver</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr id="noProductsRow">
                    <td colspan="9" class="text-center">No hay productos registrados.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div id="searchResults" class="mb-3"></div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const filas = document.querySelectorAll('.producto-row');
            const noProductsRow = document.getElementById('noProductsRow');
            const searchResults = document.getElementById('searchResults');

            searchInput.addEventListener('input', function () {
                const filtro = this.value.toLowerCase().trim();
                let resultadosVisibles = 0;

                filas.forEach(fila => {
                    const celdas = fila.querySelectorAll('td');
                    const serie = celdas[1].textContent.toLowerCase();
                    const codigo = celdas[2].textContent.toLowerCase();
                    const nombre = celdas[3].textContent.toLowerCase();

                    if (
                        filtro === '' ||
                        serie.includes(filtro) ||
                        codigo.includes(filtro) ||
                        nombre.includes(filtro)
                    ) {
                        fila.style.display = '';
                        resultadosVisibles++;

                        if (filtro !== '') {
                            resaltarTexto(celdas[1], filtro);
                            resaltarTexto(celdas[2], filtro);
                            resaltarTexto(celdas[3], filtro);
                        } else {
                            quitarResaltado(celdas[1]);
                            quitarResaltado(celdas[2]);
                            quitarResaltado(celdas[3]);
                        }
                    } else {
                        fila.style.display = 'none';
                    }
                });

                mostrarResultados(filtro, resultadosVisibles);

                if (noProductsRow) {
                    if (filtro === '') {
                        noProductsRow.style.display = filas.length === 0 ? '' : 'none';
                    } else {
                        noProductsRow.style.display = resultadosVisibles === 0 ? '' : 'none';
                    }
                }
            });

            function resaltarTexto(elemento, termino) {
                const textoOriginal = elemento.getAttribute('data-original') || elemento.textContent;

                if (!elemento.getAttribute('data-original')) {
                    elemento.setAttribute('data-original', textoOriginal);
                }

                const regex = new RegExp(escapeRegex(termino), 'gi');
                const textoResaltado = textoOriginal.replace(regex, '<mark style="background-color: #ffeb3b; padding: 2px;">$&</mark>');
                elemento.innerHTML = textoResaltado;
            }

            function quitarResaltado(elemento) {
                const textoOriginal = elemento.getAttribute('data-original');
                if (textoOriginal) {
                    elemento.textContent = textoOriginal;
                    elemento.removeAttribute('data-original');
                }
            }

            function escapeRegex(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            function mostrarResultados(termino, cantidad) {
                const totalFilas = document.querySelectorAll('.producto-row').length;

                if (termino === '') {
                    searchResults.innerHTML = '';
                    return;
                }

                if (cantidad === 0) {
                    searchResults.innerHTML = `
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    No se encontraron productos con el término "<strong>${termino}</strong>"
                </div>
            `;
                } else {
                    searchResults.innerHTML = `
                <div>
                    Mostrando <strong>${cantidad}</strong> de <strong>${totalFilas}</strong> productos encontrados para "<strong>${termino}</strong>"
                </div>
            `;
                }
            }

            function bloquearEspacioAlInicio(e, input) {
                if (e.key === ' ' && input.selectionStart === 0) {
                    e.preventDefault();
                }
            }

            function eliminarEspaciosIniciales(input) {
                input.value = input.value.replace(/^\s+/, '');

                if (input.value.length > 30) {
                    input.value = input.value.substring(0, 30);
                }
            }
        });
    </script>

    <div class="d-flex justify-content mt-5">
        <a href="/" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-2"></i> Volver al Inicio
        </a>
    </div>

    <?php echo e($productos->links()); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/productos/index.blade.php ENDPATH**/ ?>