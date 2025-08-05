<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Editar Servicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background-color: #e6f0ff;
            font-size: 1.1rem;
        }
        .form-contenedor {
            max-width: 1000px;
            margin: auto;
            background-color: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .was-validated .form-control:valid,
        .was-validated .form-select:valid,
        .was-validated textarea:valid {
            background-image: none !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="form-contenedor position-relative">
        <!-- Título e ícono izquierdo -->
        <h2 class="text-center mb-4 text-primary fs-4">
            <i class="bi bi-pencil-square me-2"></i> Editar servicio
        </h2>

        <!-- Ícono decorativo a la derecha -->
        <div class="position-absolute top-0 end-0 me-3 mt-2 d-none d-md-block" style="font-size: 4rem; color: #dce6f5;">
            <i class="bi bi-shield-lock"></i>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert" style="font-size: 0.85rem;">
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <form id="servicioForm" action="{{ route('servicios.update', $servicio->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">

                {{-- Nombre --}}
                <div class="col-md-6">
                    <label for="nombreServicio" class="form-label fs-6 mb-2">Nombre del servicio</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <input type="text" id="nombreServicio" name="nombreServicio" class="form-control form-control-md"
                               value="{{ old('nombreServicio', $servicio->nombre) }}"
                               maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                               title="Solo letras, máximo 50 caracteres"
                               onkeydown="bloquearEspacioAlInicio(event, this)"
                               oninput="eliminarEspaciosIniciales(this)" required />
                        <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un nombre válido.</div>
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="col-md-6">
                    <label for="descripcionServicio" class="form-label fs-6 mb-2">Descripción</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                        <textarea id="descripcionServicio" name="descripcionServicio" class="form-control form-control-md"
                                  maxlength="125" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                  onkeydown="bloquearEspacioAlInicio(event, this)"
                                  oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                  rows="1" required
                                  style="overflow:hidden; resize:none;">{{ old('descripcionServicio', $servicio->descripcion) }}</textarea>
                        <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese una descripción válida.</div>
                    </div>
                </div>

                {{-- Costo --}}
                <div class="col-md-6">
                    <label for="costo" class="form-label fs-6 mb-2">Costo estimado (L)</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                        <input type="text" id="costo" class="form-control form-control-md" name="costo"
                               value="{{ old('costo', $servicio->costo) }}"
                               pattern="^[1-9][0-9]{0,3}$" maxlength="4" required />
                        <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo válido.</div>
                    </div>
                </div>

                {{-- Duración --}}
                @php
                    $duracion_cantidad = $duracion[0] ?? '';
                    $duracion_tipo = $duracion[1] ?? '';
                @endphp
                <div class="col-sm-5">
                    <label for="duracionCantidad" class="form-label fs-6 mb-2">Duración estimada</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                        <input type="number" id="duracionCantidad" class="form-control form-control-md" name="duracion_cantidad"
                               value="{{ old('duracion_cantidad', $duracion_cantidad) }}"
                               min="1" max="99" placeholder="Cantidad" required />
                        <select id="duracionTipo" class="form-select form-select-md" name="duracion_tipo" required>
                            <option value="">Unidad</option>
                            <option value="horas" {{ old('duracion_tipo', $duracion_tipo) == 'horas' ? 'selected' : '' }}>Horas</option>
                            <option value="dias" {{ old('duracion_tipo', $duracion_tipo) == 'dias' ? 'selected' : '' }}>Días</option>
                            <option value="meses" {{ old('duracion_tipo', $duracion_tipo) == 'meses' ? 'selected' : '' }}>Meses</option>
                            <option value="años" {{ old('duracion_tipo', $duracion_tipo) == 'años' ? 'selected' : '' }}>Años</option>
                        </select>
                        <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese una duración válida.</div>
                    </div>
                </div>

                {{-- Categoría --}}
                <div class="col-md-6">
                    <label for="categoria" class="form-label fs-6 mb-2">Categoría</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-ui-checks"></i></span>
                        <select id="categoria" class="form-select form-select-md" name="categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="vigilancia" {{ old('categoria', strtolower($servicio->categoria)) == 'vigilancia' ? 'selected' : '' }}>Vigilancia</option>
                            <option value="tecnico" {{ old('categoria', strtolower($servicio->categoria)) == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        </select>
                        <div class="invalid-feedback" style="font-size: 0.85rem;">Seleccione una categoría.</div>
                    </div>
                </div>

                {{-- Productos requeridos --}}
                <div class="col-sm-6">
                    <label for="productosCategoria" class="form-label fs-6 mb-2">Productos requeridos</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <select id="productosCategoria" class="form-select form-select-md" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="vigilancia" {{ old('categoria', strtolower($servicio->categoria)) == 'vigilancia' ? 'selected' : '' }}>Vigilancia</option>
                            <option value="tecnico" {{ old('categoria', strtolower($servicio->categoria)) == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        </select>
                        <div class="invalid-feedback" style="font-size: 0.85rem;">Seleccione una categoría de productos.</div>
                    </div>
                </div>

                {{-- Productos por categoría --}}
                @php
                    $productosSeleccionados = json_decode($servicio->productos, true) ?? [];
                @endphp

                <div class="col-md-12 {{ strtolower($servicio->categoria) == 'vigilancia' ? '' : 'd-none' }}" id="productos_vigilancia">
                    <label class="form-label fs-6 mb-2">Productos de vigilancia</label>
                    <div class="row g-2" style="font-size: 0.85rem;">
                        @foreach($productosVigilancia as $producto)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto->id }}"
                                           {{ in_array($producto->id, $productosSeleccionados) ? 'checked' : '' }}
                                           id="vig_{{ Str::slug($producto->nombre, '_') }}">
                                    <label class="form-check-label" for="vig_{{ Str::slug($producto->nombre, '_') }}">
                                        {{ $producto->nombre }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-12 {{ strtolower($servicio->categoria) == 'tecnico' ? '' : 'd-none' }}" id="productos_tecnico">
                    <label class="form-label fs-6 mb-2">Productos técnicos</label>
                    <div class="row g-2" style="font-size: 0.85rem;">
                        @foreach($productosTecnicos as $producto)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto->id }}"
                                           {{ in_array($producto->id, $productosSeleccionados) ? 'checked' : '' }}
                                           id="tec_{{ Str::slug($producto->nombre, '_') }}">
                                    <label class="form-check-label" for="tec_{{ Str::slug($producto->nombre, '_') }}">
                                        {{ $producto->nombre }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Botones --}}
                <div class="text-center mt-4">
                    <a href="{{ route('servicios.catalogo') }}" class="btn btn-danger me-2" style="font-size: 0.85rem;">
                        <i class="bi bi-x-circle me-2"></i> Cancelar
                    </a>

                    <button type="button" id="btnRestablecer" class="btn btn-warning me-2" style="font-size: 0.85rem;">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                    </button>

                    <button type="submit" class="btn btn-primary" style="font-size: 0.85rem;">
                        <i class="bi bi-save-fill me-2"></i> Guardar cambios
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    function autoExpand(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }

    function eliminarEspaciosIniciales(input) {
        input.value = input.value.replace(/^\s+/, '');
    }

    function bloquearEspacioAlInicio(e, input) {
        if (e.key === ' ' && input.selectionStart === 0) {
            e.preventDefault();
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        // Auto expand textarea on load
        autoExpand(document.getElementById('descripcionServicio'));

        const categoriaSelect = document.getElementById('categoria');
        const productosCategoriaSelect = document.getElementById('productosCategoria');
        const vigilanciaDiv = document.getElementById('productos_vigilancia');
        const tecnicoDiv = document.getElementById('productos_tecnico');
        const form = document.getElementById('servicioForm');
        const btnRestablecer = document.getElementById('btnRestablecer');

        // Guardar estado original para resetear
        const estadoOriginal = {
            nombreServicio: document.getElementById('nombreServicio').value,
            descripcionServicio: document.getElementById('descripcionServicio').value,
            costo: document.getElementById('costo').value,
            duracionCantidad: document.getElementById('duracionCantidad').value,
            duracionTipo: document.getElementById('duracionTipo').value,
            categoria: categoriaSelect.value,
            productosCategoria: productosCategoriaSelect.value,
            productosSeleccionados: Array.from(form.querySelectorAll('input[name="productos[]"]:checked')).map(cb => cb.value),
        };

        function mostrarProductosSegunCategoria(categoria) {
            vigilanciaDiv.classList.add('d-none');
            tecnicoDiv.classList.add('d-none');
            if (categoria === 'vigilancia') {
                vigilanciaDiv.classList.remove('d-none');
            } else if (categoria === 'tecnico') {
                tecnicoDiv.classList.remove('d-none');
            }
        }

        productosCategoriaSelect.addEventListener('change', function () {
            mostrarProductosSegunCategoria(this.value);
        });

        categoriaSelect.addEventListener('change', function () {
            const cat = this.value.toLowerCase();

            // Sincronizar productosCategoria con categoria
            productosCategoriaSelect.value = cat;

            // Deshabilitar opciones en productosCategoria que no coincidan
            for (let opt of productosCategoriaSelect.options) {
                opt.disabled = opt.value !== cat && opt.value !== '';
            }

            // Mostrar productos correspondientes
            mostrarProductosSegunCategoria(cat);
        });

        // Mostrar productos al cargar la página
        mostrarProductosSegunCategoria(productosCategoriaSelect.value);

        // Validaciones personalizadas de inputs
        function validarInput(e, pattern, maxLength) {
            const input = e.target;
            let valor = input.value;
            let regex = new RegExp(pattern, 'g');
            let soloPermitidos = valor.match(regex);
            valor = soloPermitidos ? soloPermitidos.join('') : '';
            if (valor.length > maxLength) valor = valor.substring(0, maxLength);
            input.value = valor;
        }

        document.getElementById('nombreServicio').addEventListener('input', e => {
            validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 50);
        });

        document.getElementById('descripcionServicio').addEventListener('input', e => {
            validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 125);
        });

        document.getElementById('costo').addEventListener('input', function () {
            let valor = this.value.replace(/\D/g, '');
            if (valor.startsWith('0')) valor = valor.replace(/^0+/, '');
            this.value = valor.slice(0, 4);
        });

        document.getElementById('duracionCantidad').addEventListener('input', function () {
            let valor = this.value.replace(/\D/g, '');
            valor = valor.replace(/^0+/, '');
            this.value = valor.slice(0, 2);
        });

        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        btnRestablecer.addEventListener('click', () => {
            // Restaurar valores originales
            document.getElementById('nombreServicio').value = estadoOriginal.nombreServicio;
            document.getElementById('descripcionServicio').value = estadoOriginal.descripcionServicio;
            document.getElementById('costo').value = estadoOriginal.costo;
            document.getElementById('duracionCantidad').value = estadoOriginal.duracionCantidad;
            document.getElementById('duracionTipo').value = estadoOriginal.duracionTipo;
            categoriaSelect.value = estadoOriginal.categoria;
            productosCategoriaSelect.value = estadoOriginal.productosCategoria;

            mostrarProductosSegunCategoria(estadoOriginal.productosCategoria);

            const checkboxes = form.querySelectorAll('input[name="productos[]"]');
            checkboxes.forEach(cb => {
                cb.checked = estadoOriginal.productosSeleccionados.includes(cb.value);
            });

            form.classList.remove('was-validated');
            autoExpand(document.getElementById('descripcionServicio'));
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
