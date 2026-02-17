@extends('plantilla')

@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header text-white rounded-top-4 py-3 text-center" style="background-color: #1a2340;">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-lock-fill me-2"></i>Editar rol "{{ $role->name }}"
                    </h4>
                </div>

                <form id="formRoles" action="{{ route('roles_permisos.actualizar', $role->id) }}" method="POST" class="p-4 bg-white rounded-bottom-4 text-start">
                    @csrf
                    @method('PUT')

                    {{-- Nombre del rol --}}
                    <div class="mb-4 position-relative">
                        <label class="form-label fw-bold">Nombre del rol</label>
                        <div class="input-group shadow-sm rounded">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-person-badge-fill text-primary"></i>
                        </span>
                            <input
                                list="rolesList"
                                name="role"
                                id="roleSelect"
                                class="form-control border-0"
                                placeholder="Ingrese un rol"
                                value="{{ old('role', $role->name) }}"
                                maxlength="75"
                                pattern="^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ ]+$"
                                title="Solo se permiten letras, números, espacios y acentos."
                                required
                            >
                            <datalist id="rolesList">
                                @foreach($roles as $r)
                                    @if($r->name !== 'super_admin')
                                        <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                                    @endif
                                @endforeach
                            </datalist>
                        </div>
                        <div id="alertaRol" class="form-text text-danger d-none mt-1">
                            Debe ingresar un rol antes de guardar.
                        </div>
                    </div>

                    {{-- Permisos --}}
                    <div class="mb-4 position-relative">
                        <label class="form-label fw-bold">Permisos de este rol</label>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-bold" for="selectAll">
                                <i class="bi bi-check2-all me-1 text-primary"></i> Seleccionar todos
                            </label>
                        </div>

                        <div class="border rounded-4 p-3 bg-light shadow-sm" style="max-height: 450px; overflow-y:auto;">
                            @foreach($permisosPorModulo as $modulo => $perms)
                                <div class="mb-3 p-3 rounded" style="border: 2px solid #1a2340;">
                                    <h6 class="fw-bold mb-2">{{ $modulo }}</h6>
                                    <div style="column-count: 2;">
                                        @foreach($perms as $perm)
                                            @php
                                                $tipo = Str::contains($perm->name, 'listado') ? 'listado' : (Str::contains($perm->name, 'ver') ? 'ver' : (Str::contains($perm->name, 'editar') ? 'editar' : 'otro'));
                                            @endphp
                                            <div class="form-check mb-1">
                                                <input class="form-check-input permission-checkbox"
                                                       type="checkbox"
                                                       name="permissions[]"
                                                       value="{{ $perm->id }}"
                                                       id="perm-{{ $perm->id }}"
                                                       data-tipo="{{ $tipo }}"
                                                       @if(in_array($perm->id, $rolePermisos)) checked @endif
                                                >
                                                <label class="form-check-label" for="perm-{{ $perm->id }}">
                                                    {{ ucfirst($perm->name) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="alertaPermisos" class="form-text text-danger d-none mt-1">
                            Seleccione al menos un permiso.
                        </div>
                        <div id="alertaListados" class="form-text text-danger d-none mt-1">
                            Debe seleccionar "Listados" si ha marcado "Ver" o "Editar".
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-between gap-2 botones">
                        <a href="{{ route('roles_permisos.index') }}" class="btn btn-outline-danger w-100 fw-bold hover-shadow">
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

        // Guardamos el estado inicial
        const permisosIniciales = Array.from(permisos).map(cb => cb.checked);
        const roleInicial = roleSelect.value;

        // Expresión regular para validar caracteres permitidos (letras, números, espacios y acentos)
        const regexRol = /^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ ]+$/;

        // Función para validar el rol y mostrar alerta personalizada
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

        // Validar rol mientras el usuario escribe
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

                // Ocultar alerta de permisos si hay alguno marcado
                const permisosSeleccionados = Array.from(permisos).some(p => p.checked);
                if (permisosSeleccionados) {
                    alertaPermisos.classList.add('d-none');
                }
            });
        });

        // Función para obtener el módulo padre de un checkbox
        function getModuloDiv(cb) {
            return cb.closest('div[style*="border: 2px solid"]');
        }

        // Forzar listados dentro del mismo módulo y mostrar alerta debajo
        permisos.forEach(cb => {
            if(cb.dataset.tipo === 'ver' || cb.dataset.tipo === 'editar') {
                cb.addEventListener('change', function() {
                    const moduloDiv = getModuloDiv(cb);
                    const listadoCheckbox = moduloDiv.querySelector('.permission-checkbox[data-tipo="listado"]');
                    if(this.checked && listadoCheckbox) {
                        listadoCheckbox.checked = true;
                        alertaListados.classList.add('d-none'); // Oculta la alerta si estaba visible
                    }
                });
            }
        });

        // Evitar desmarcar listados si hay ver o editar seleccionados en el mismo módulo
        permisos.forEach(cb => {
            if(cb.dataset.tipo === 'listado') {
                cb.addEventListener('change', function() {
                    const moduloDiv = getModuloDiv(cb);
                    const verEditarSeleccionados = Array.from(moduloDiv.querySelectorAll('.permission-checkbox')).some(p =>
                        (p.dataset.tipo === 'ver' || p.dataset.tipo === 'editar') && p.checked
                    );
                    if(!this.checked && verEditarSeleccionados) {
                        this.checked = true;
                        alertaListados.classList.remove('d-none'); // Mostrar alerta debajo del campo
                    } else {
                        alertaListados.classList.add('d-none');
                    }
                });
            }
        });

        // Validación al enviar
        form.addEventListener('submit', function(e) {
            let valid = true;

            // Validar rol usando la función personalizada
            if(!validarRol()) valid = false;

            // Al menos un permiso
            const permisosSeleccionados = Array.from(permisos).filter(cb => cb.checked);
            if(permisosSeleccionados.length === 0) {
                alertaPermisos.classList.remove('d-none');
                valid = false;
            } else {
                alertaPermisos.classList.add('d-none');
            }

            // Verificar listados por módulo
            const moduloDivs = form.querySelectorAll('div[style*="border: 2px solid"]');
            let listaValida = true;
            moduloDivs.forEach(modulo => {
                const verEditarSeleccionados = Array.from(modulo.querySelectorAll('.permission-checkbox')).some(p =>
                    (p.dataset.tipo === 'ver' || p.dataset.tipo === 'editar') && p.checked
                );
                const listadoSeleccionado = Array.from(modulo.querySelectorAll('.permission-checkbox')).some(p =>
                    p.dataset.tipo === 'listado' && p.checked
                );
                if(verEditarSeleccionados && !listadoSeleccionado) {
                    listaValida = false;
                }
            });
            if(!listaValida) {
                alertaListados.classList.remove('d-none'); // Mostrar alerta debajo
                valid = false;
            } else {
                alertaListados.classList.add('d-none');
            }

            if(!valid) e.preventDefault();
        });
    </script>


@endsection
