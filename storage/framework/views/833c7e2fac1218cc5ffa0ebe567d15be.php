<?php $__env->startSection('titulo','Registrar un nuevo producto al inventario'); ?>
<?php $__env->startSection('content'); ?>

    <style>
        body {
            background-color: #e6f0ff;
            margin: 0;
        }
    </style>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-white p-5 rounded shadow-lg position-relative">

                    <div class="position-absolute top-0 end-0 p-3 text-secondary opacity-25">
                        <i class="bi bi-box-seam" style="font-size: 4rem;"></i>
                    </div>

                    <h3 class="text-center mb-4" style="color: #09457f;">
                        <i class="bi bi-boxes me-2"></i>
                        <?php if(isset($inventario)): ?>
                            Editar un producto
                        <?php else: ?>
                            Registrar un nuevo producto
                        <?php endif; ?>
                    </h3>


                    <form method="POST" action="<?php echo e(isset($inventario) ? route('inventarios.update', $inventario->id) : route('inventarios.store')); ?>" novalidate>
                        <?php echo csrf_field(); ?>
                        <?php if(isset($inventario)): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="codigo" class="form-label">Código del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="codigo" class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="10" value="<?php echo e(old('codigo', $inventario->codigo ?? '')); ?>" onkeypress="validarTexto(event)" required>
                                </div>
                                <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="nombre" class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="30" value="<?php echo e(old('nombre', $inventario->nombre ?? '')); ?>" onkeypress="return soloLetras(event)" required>
                                </div>
                                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-123"></i></span>
                                    <input type="number" name="cantidad" class="form-control <?php $__errorArgs = ['cantidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1" max="999" maxlength="3" value="<?php echo e(old('cantidad', $inventario->cantidad ?? '')); ?>" required onkeypress="return soloNumeros(event)">
                                </div>
                                <?php $__errorArgs = ['cantidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="precio_unitario" class="form-label">Precio unitario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                    <input type="text" name="precio_unitario" class="form-control <?php $__errorArgs = ['precio_unitario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="4"
                                           value="<?php echo e(old('precio_unitario', $inventario->precio_unitario ?? '')); ?>"
                                           oninput="validarPrecio(this)" required >
                                </div>
                                <?php $__errorArgs = ['precio_unitario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text-fill"></i></span>
                                    <textarea name="descripcion" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="255" onkeypress="return validarDescripcion(event)" required><?php echo e(old('descripcion', $inventario->descripcion ?? '')); ?></textarea>
                                </div>
                                <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1 small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="<?php echo e(route('inventarios.index')); ?>" class="btn btn-danger me-2">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>

                            <button type="reset" class="btn btn-warning me-2">
                                <i class="bi bi-eraser-fill me-2"></i> Limpiar
                            </button>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save-fill me-2"></i> Guardar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Boton Limpiar -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const resetBtn = document.querySelector('button[type="reset"]');

            if (resetBtn) {
                resetBtn.addEventListener('click', function (e) {
                    e.preventDefault(); // evita el comportamiento por defecto del botón reset

                    const form = this.closest('form');
                    if (!form) return;

                    // Limpiar manualmente cada campo
                    form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(el => {
                        el.value = '';
                    });

                    form.querySelectorAll('select').forEach(el => {
                        el.selectedIndex = 0;
                    });

                    // Remover clases de validación
                    form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                        el.classList.remove('is-valid', 'is-invalid');
                    });

                    // Limpiar mensajes de error si hay
                    form.querySelectorAll('.text-danger').forEach(el => {
                        el.innerText = '';
                    });
                });
            }
        });
    </script>



    <!-- Validaciones JS -->
    <script>
        function soloLetras(e) {
            let key = e.keyCode || e.which;
            let tecla = String.fromCharCode(key).toLowerCase();
            let letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            let especiales = [8, 37, 39, 46];
            let input = e.target;

            if (tecla === '.' || tecla === "'" || (letras.indexOf(tecla) === -1 && !especiales.includes(key))) {
                e.preventDefault();
                return false;
            }

            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            if (key === 32) {
                const valor = input.value;
                const pos = input.selectionStart;
                if (valor.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }
            return true;
        }

        function soloNumeros(e) {
            const permitidos = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Delete'];
            if (/\d/.test(e.key) || permitidos.includes(e.key)) {
                return true;
            }
            if (e.key === '.' && !e.target.value.includes('.')) {
                return true;
            }
            e.preventDefault();
            return false;
        }

        function validarTexto(e) {
            const key = e.keyCode || e.which;
            const tecla = String.fromCharCode(key);
            const input = e.target;

            // Evitar espacio al inicio
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            // Evitar múltiples espacios seguidos
            const pos = input.selectionStart;
            if (key === 32 && input.value.charAt(pos - 1) === ' ') {
                e.preventDefault();
                return false;
            }

            return true;
        }

        // Limitar cantidad a 3 dígitos máximo (1 a 999)
        document.addEventListener("DOMContentLoaded", function () {
            const cantidadInput = document.querySelector('input[name="cantidad"]');

            if (cantidadInput) {
                cantidadInput.addEventListener('input', function () {
                    if (this.value.length > 3) {
                        this.value = this.value.slice(0, 3);
                    }

                    // Asegurarse de que sea máximo 999
                    if (parseInt(this.value) > 999) {
                        this.value = '999';
                    }
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const cantidadInput = document.querySelector('input[name="cantidad"]');

            if (cantidadInput) {
                cantidadInput.addEventListener('input', function () {
                    // Evitar 0 inicial o valores mayores a 999
                    let valor = this.value.replace(/^0+/, ''); // quita ceros a la izquierda

                    if (parseInt(valor) > 999) valor = '999';
                    this.value = valor;
                });
            }
        });

        function validarPrecio(input) {
            let valor = input.value;

            // Quitar caracteres no permitidos (solo números y punto)
            valor = valor.replace(/[^\d.]/g, '');

            // Separar entero y decimal
            let partes = valor.split('.');

            // Limitar parte entera a 9 dígitos
            partes[0] = partes[0].substring(0, 9);

            // Limitar parte decimal a 2 dígitos
            if (partes[1]) {
                partes[1] = partes[1].substring(0, 2);
                valor = partes[0] + '.' + partes[1];
            } else {
                valor = partes[0];
            }

            // Si el valor es 0 o 0.00, forzar a vacío
            if (parseFloat(valor) === 0) {
                input.value = '';
            } else {
                input.value = valor;
            }
        }



        document.querySelector('input[name="codigo"]').addEventListener('input', function () {
            if (this.value.match(/^0+$/)) {
                this.value = '';
            }
        });


        function validarDescripcion(e) {
            const key   = e.keyCode || e.which;
            const char  = String.fromCharCode(key);
            const input = e.target;
            const pos   = input.selectionStart;

            // 1. Bloquear si primer carácter no es letra (solo letras al inicio)
            if (pos === 0 && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ]$/.test(char)) {
                e.preventDefault();
                return false;
            }

            // 2. Bloquear espacio al inicio
            if (key === 32 && input.selectionStart === 0) {
                e.preventDefault();
                return false;
            }

            // 3. Bloquear espacios dobles
            if (key === 32) {
                const pos = input.selectionStart;
                if (input.value.charAt(pos - 1) === ' ') {
                    e.preventDefault();
                    return false;
                }
            }

            // Permitir resto de caracteres
            return true;
        }
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/inventarios/formulario.blade.php ENDPATH**/ ?>