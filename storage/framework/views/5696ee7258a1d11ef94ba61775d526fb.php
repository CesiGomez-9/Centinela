<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center py-5">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header text-white rounded-top-4 py-3 text-center" style="background-color: #1a2340;">
                    <h4 class="mb-0"><i class="bi bi-shield-lock-fill me-2"></i>Asignar nuevo rol</h4>
                </div>

                <form id="formRoles" action="<?php echo e(route('roles_permisos.guardar')); ?>" method="POST" class="p-4 bg-white rounded-bottom-4 text-start">
                    <?php echo csrf_field(); ?>

                    
                    <div class="mb-4 position-relative">
                        <label class="form-label fw-bold">Nombre del rol</label>
                        <div class="input-group shadow-sm rounded">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-person-badge-fill text-primary"></i>
                        </span>
                            <input
                                name="role"
                                id="roleSelect"
                                class="form-control border-0"
                                placeholder="Ingrese un rol"
                                maxlength="75"
                                required
                            >
                        </div>
                        <div id="alertaRol" class="form-text text-danger d-none mt-1">Debe ingresar un rol antes de guardar.</div>
                    </div>

                    
                    <div class="mb-4 position-relative">
                        <label class="form-label fw-bold">Permisos de este rol</label>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-bold" for="selectAll">
                                <i class="bi bi-check2-all me-1 text-primary"></i> Seleccionar todos
                            </label>
                        </div>

                        <div class="border rounded-4 p-3 bg-light shadow-sm" style="max-height: 450px; overflow-y:auto;">
                            <?php $__currentLoopData = $permisosPorModulo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-3 p-3 rounded" style="border: 2px solid #1a2340;">
                                    <h6 class="fw-bold mb-2"><?php echo e($modulo); ?></h6>
                                    <div style="column-count: 2;">
                                        <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $tipo = Str::contains($perm->name, 'listado') ? 'listado' : (Str::contains($perm->name, 'ver') ? 'ver' : (Str::contains($perm->name, 'editar') ? 'editar' : 'otro'));
                                            ?>
                                            <div class="form-check mb-1">
                                                <input class="form-check-input permission-checkbox"
                                                       type="checkbox"
                                                       name="permissions[]"
                                                       value="<?php echo e($perm->id); ?>"
                                                       id="perm-<?php echo e($perm->id); ?>"
                                                       data-tipo="<?php echo e($tipo); ?>">
                                                <label class="form-check-label" for="perm-<?php echo e($perm->id); ?>"><?php echo e(ucfirst($perm->name)); ?></label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div id="alertaPermisos" class="form-text text-danger d-none mt-1">Seleccione al menos un permiso.</div>
                        <div id="alertaListados" class="form-text text-danger d-none mt-1">Debe seleccionar "Listados" si ha marcado "Ver" o "Editar".</div>
                    </div>

                    
                    <div class="d-flex justify-content-between gap-2 botones">
                        <a href="<?php echo e(route('roles_permisos.index')); ?>" class="btn btn-outline-danger w-100 fw-bold hover-shadow">
                            <i class="bi bi-x-circle me-2"></i> Cancelar
                        </a>

                        <button type="button" class="btn btn-outline-secondary w-100 fw-bold hover-shadow" id="btnRestablecer">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                        </button>

                        <button type="submit" class="btn btn-primary w-100 fw-bold hover-shadow text-white">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('formRoles');
        const roleSelect = document.getElementById('roleSelect');
        const alertaRol = document.getElementById('alertaRol');
        const permisos = form.querySelectorAll('.permission-checkbox');
        const alertaPermisos = document.getElementById('alertaPermisos');
        const alertaListados = document.getElementById('alertaListados');
        const selectAllCheckbox = document.getElementById('selectAll');
        const btnRestablecer = document.getElementById('btnRestablecer');

        // Guardar estado inicial
        const permisosIniciales = Array.from(permisos).map(cb => cb.checked);
        const roleInicial = roleSelect.value;
        const regexRol = /^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ ]+$/;

        function validarRol() {
            const valor = roleSelect.value.trim();
            if(valor === "") {
                alertaRol.textContent = "Debe ingresar un rol antes de guardar.";
                alertaRol.classList.remove('d-none');
                return false;
            } else if(!regexRol.test(valor)) {
                alertaRol.textContent = "Solo se permiten letras, números, espacios y acentos.";
                alertaRol.classList.remove('d-none');
                return false;
            } else if(valor.length > 75) {
                alertaRol.textContent = "El rol no puede superar 75 caracteres.";
                alertaRol.classList.remove('d-none');
                return false;
            }
            alertaRol.classList.add('d-none');
            return true;
        }

        roleSelect.addEventListener('input', validarRol);

        // Restablecer
        btnRestablecer.addEventListener('click', () => {
            roleSelect.value = roleInicial;
            permisos.forEach((cb, i) => cb.checked = permisosIniciales[i]);
            selectAllCheckbox.checked = Array.from(permisos).every(cb => cb.checked);
            [alertaRol, alertaPermisos, alertaListados].forEach(a => a.classList.add('d-none'));
        });

        // Seleccionar todos
        selectAllCheckbox.addEventListener('change', function() {
            permisos.forEach(cb => cb.checked = this.checked);
            alertaPermisos.classList.add('d-none');
        });

        // Actualizar check "Seleccionar todos" y ocultar alertas
        permisos.forEach(cb => {
            cb.addEventListener('change', function () {
                selectAllCheckbox.checked = Array.from(permisos).every(p => p.checked);
                const permisosSeleccionados = Array.from(permisos).some(p => p.checked);
                if (permisosSeleccionados) alertaPermisos.classList.add('d-none');
            });
        });

        // Función para obtener módulo padre
        function getModuloDiv(cb) {
            return cb.closest('div[style*="border: 2px solid"]');
        }

        // Forzar listados
        permisos.forEach(cb => {
            if(cb.dataset.tipo === 'ver' || cb.dataset.tipo === 'editar') {
                cb.addEventListener('change', function() {
                    const moduloDiv = getModuloDiv(cb);
                    const listadoCheckbox = moduloDiv.querySelector('.permission-checkbox[data-tipo="listado"]');
                    if(this.checked && listadoCheckbox) {
                        listadoCheckbox.checked = true;
                        alertaListados.classList.add('d-none');
                    }
                });
            }
        });

        // Evitar desmarcar listado si hay ver o editar
        permisos.forEach(cb => {
            if(cb.dataset.tipo === 'listado') {
                cb.addEventListener('change', function() {
                    const moduloDiv = getModuloDiv(cb);
                    const verEditarSeleccionados = Array.from(moduloDiv.querySelectorAll('.permission-checkbox')).some(p =>
                        (p.dataset.tipo === 'ver' || p.dataset.tipo === 'editar') && p.checked
                    );
                    if(!this.checked && verEditarSeleccionados) {
                        this.checked = true;
                        alertaListados.classList.remove('d-none');
                    } else {
                        alertaListados.classList.add('d-none');
                    }
                });
            }
        });

        // Validación al enviar
        form.addEventListener('submit', function(e) {
            let valid = true;

            if(!validarRol()) valid = false;

            const permisosSeleccionados = Array.from(permisos).filter(cb => cb.checked);
            if(permisosSeleccionados.length === 0) {
                alertaPermisos.classList.remove('d-none');
                valid = false;
            } else {
                alertaPermisos.classList.add('d-none');
            }

            const moduloDivs = form.querySelectorAll('div[style*="border: 2px solid"]');
            let listaValida = true;
            moduloDivs.forEach(modulo => {
                const verEditarSeleccionados = Array.from(modulo.querySelectorAll('.permission-checkbox')).some(p =>
                    (p.dataset.tipo === 'ver' || p.dataset.tipo === 'editar') && p.checked
                );
                const listadoSeleccionado = Array.from(modulo.querySelectorAll('.permission-checkbox')).some(p =>
                    p.dataset.tipo === 'listado' && p.checked
                );
                if(verEditarSeleccionados && !listadoSeleccionado) listaValida = false;
            });
            if(!listaValida) {
                alertaListados.classList.remove('d-none');
                valid = false;
            } else {
                alertaListados.classList.add('d-none');
            }

            if(!valid) e.preventDefault();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/roles_permisos/asignar.blade.php ENDPATH**/ ?>