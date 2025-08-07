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
        /* Quitar icono check de validación en inputs, selects y textareas */
        .was-validated .form-control:valid,
        .was-validated .form-select:valid,
        .was-validated textarea:valid {
            background-image: none !important;
            box-shadow: none !important;
        }
        /* ESTO ES CRUCIAL: Asegura que los mensajes de error se muestren */
        .is-invalid + .text-danger.small {
            display: block !important;
        }
        .is-invalid + .invalid-feedback {
            display: block !important;
        }

        #servicioForm {
            font-size: 0.85rem; /* 85% tamaño base */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="{{ asset('centinela.jpg') }}" style="height:80px; margin-right: 10px;" />
            Grupo Centinela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrate</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-3">
    <div class="form-contenedor position-relative">
        <!-- Título e ícono izquierdo -->
        <h2 class="text-center mb-4 text-primary fs-8">
            <i class="bi bi-journal-plus me-2"></i> Editar un servicio
        </h2>

        <!-- Ícono decorativo a la derecha -->
        <div class="position-absolute top-0 end-0 me-3 mt-2 d-none d-md-block" style="font-size: 4rem; color: #dce6f5;">
            <i class="bi bi-shield-lock"></i> <!-- o bi-tools -->
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert" style="font-size: 0.85rem;">
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif


        <form id="servicioForm" action="{{ route('servicios.update', $servicio->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT') {{-- Importante para las actualizaciones --}}

            {{-- TEMPORAL: Muestra todos los errores de validación (DEBE APARECER SI HAY ERRORES) --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Errores de validación:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- FIN TEMPORAL --}}

            <div class="row g-3">

                <!-- Nombre del servicio (ahora col-md-3) -->
                <div class="col-12 col-md-3">
                    <label for="nombreServicio" class="form-label fs-6 mb-2">Nombre del servicio</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <input type="text" id="nombreServicio" name="nombreServicio"
                               class="form-control @error('nombreServicio') is-invalid @enderror"
                               maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                               title="Solo letras, máximo 50 caracteres"
                               value="{{ old('nombreServicio', $servicio->nombre) }}"
                               onkeydown="bloquearEspacioAlInicio(event, this)"
                               oninput="eliminarEspaciosIniciales(this)" required />
                    </div>
                    @error('nombreServicio')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Costo Diurno (ahora col-md-3) -->
                <div class="col-12 col-md-3">
                    <label for="costo_diurno" class="form-label fs-6 mb-2">Costo diurno</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-sun"></i></span>
                        <input type="number" step="0.01"
                               class="form-control @error('costo_diurno') is-invalid @enderror"
                               id="costo_diurno" name="costo_diurno"
                               min="0" max="9999" value="{{ old('costo_diurno', $servicio->costo_diurno) }}"
                               oninput="limitarDigitos(this, 4)" required />
                    </div>
                    @error('costo_diurno')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Costo Nocturno (ahora col-md-3) -->
                <div class="col-12 col-md-3">
                    <label for="costo_nocturno" class="form-label fs-6 mb-2">Costo nocturno</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-moon"></i></span>
                        <input type="number" step="0.01"
                               class="form-control @error('costo_nocturno') is-invalid @enderror"
                               id="costo_nocturno" name="costo_nocturno"
                               min="0" max="9999" value="{{ old('costo_nocturno', $servicio->costo_nocturno) }}"
                               oninput="limitarDigitos(this, 4)" required />
                    </div>
                    @error('costo_nocturno')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Costo 24 Horas (ahora col-md-3) -->
                <div class="col-12 col-md-3">
                    <label for="costo_24_horas" class="form-label fs-6 mb-2">Costo 24 horas</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-clock"></i></span>
                        <input type="number" step="0.01"
                               class="form-control @error('costo_24_horas') is-invalid @enderror"
                               id="costo_24_horas" name="costo_24_horas"
                               min="0" max="9999" value="{{ old('costo_24_horas', $servicio->costo_24_horas) }}"
                               oninput="limitarDigitos(this, 4)" required />
                    </div>
                    @error('costo_24_horas')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Descripción (ocupa todo el ancho) -->
                <div class="col-12">
                    <label for="descripcionServicio" class="form-label fs-6 mb-2">Descripción</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                        <textarea id="descripcionServicio" name="descripcionServicio"
                                  class="form-control @error('descripcionServicio') is-invalid @enderror"
                                  maxlength="125" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                  title="Solo letras, máximo 125 caracteres"
                                  rows="1" required
                                  onkeydown="bloquearEspacioAlInicio(event, this)"
                                  oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                  style="overflow:hidden; resize:none;">{{ old('descripcionServicio', $servicio->descripcion) }}</textarea>
                    </div>
                    @error('descripcionServicio')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Categoría -->
                <div class="col-md-6">
                    <label for="categoria" class="form-label fs-6 mb-2">Categoría</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-ui-checks"></i></span>
                        <select class="form-select form-select-md @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="vigilancia" {{ old('categoria', $servicio->categoria) === 'vigilancia' ? 'selected' : '' }}>Vigilancia</option>
                            <option value="tecnico" {{ old('categoria', $servicio->categoria) === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        </select>
                    </div>
                    @error('categoria')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Productos requeridos (ahora con selección manual) -->
                <div class="col-md-6">
                    <label class="form-label fs-6 mb-2">Productos requeridos</label>
                    <div class="input-group input-group-md">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <select class="form-select form-select-md @error('productos_categoria') is-invalid @enderror" id="productosCategoria" name="productos_categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="vigilancia" {{ old('productos_categoria', (in_array($servicio->categoria, ['vigilancia', 'Implementos de seguridad']) ? 'vigilancia' : (in_array($servicio->categoria, ['tecnico', 'Cámaras de seguridad', 'Alarmas antirrobo', 'Cerraduras inteligentes', 'Sensores de movimiento', 'Luces con sensor de movimiento', 'Rejas o puertas de seguridad', 'Sistema de monitoreo 24/7']) ? 'tecnico' : ''))) === 'vigilancia' ? 'selected' : '' }}>Vigilancia</option>
                            <option value="tecnico" {{ old('productos_categoria', (in_array($servicio->categoria, ['vigilancia', 'Implementos de seguridad']) ? 'vigilancia' : (in_array($servicio->categoria, ['tecnico', 'Cámaras de seguridad', 'Alarmas antirrobo', 'Cerraduras inteligentes', 'Sensores de movimiento', 'Luces con sensor de movimiento', 'Rejas o puertas de seguridad', 'Sistema de monitoreo 24/7']) ? 'tecnico' : ''))) === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        </select>
                    </div>
                    @error('productos_categoria')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Productos de vigilancia -->
                <div class="col-12 d-none" id="productos_vigilancia">
                    <label class="form-label fs-6 mb-2">Productos de vigilancia</label>
                    <div class="row g-2" style="font-size: 0.85rem;">
                        @foreach($productosVigilancia as $producto)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto->id }}" id="vig_{{ Str::slug($producto->nombre, '_') }}"
                                        {{ in_array($producto->id, old('productos', $productosSeleccionados)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="vig_{{ Str::slug($producto->nombre, '_') }}">
                                        {{ $producto->nombre }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('productos')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Productos técnicos -->
                <div class="col-12 d-none" id="productos_tecnico">
                    <label class="form-label fs-6 mb-2">Productos técnicos</label>
                    <div class="row g-2" style="font-size: 0.85rem;">
                        @foreach($productosTecnicos as $producto) {{-- Usar productosTecnicos --}}
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto->id }}" id="tec_{{ Str::slug($producto->nombre, '_') }}"
                                    {{ in_array($producto->id, old('productos', $productosSeleccionados)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tec_{{ Str::slug($producto->nombre, '_') }}">
                                    {{ $producto->nombre }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('productos')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="text-center mt-4">
                    <a href="{{ route('servicios.catalogo') }}" class="btn btn-danger me-2" style="font-size: 0.85rem;">
                        <i class="bi bi-x-circle me-2"></i> Cancelar
                    </a>

                    <button type="reset" class="btn btn-warning me-2" style="font-size: 0.85rem;">
                        <i class="bi bi-eraser-fill me-2"></i> Limpiar
                    </button>

                    <button type="submit" class="btn btn-primary" style="font-size: 0.85rem;">
                        <i class="bi bi-save-fill me-2"></i> Guardar
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>


<script>
    function autoExpand(textarea) {
        textarea.style.height = 'auto'; // Reinicia
        textarea.style.height = (textarea.scrollHeight) + 'px'; // Ajusta al contenido
    }

    // Expande al cargar si ya tiene texto
    window.addEventListener('DOMContentLoaded', () => {
        const textarea = document.getElementById('descripcionServicio');
        if (textarea) {
            autoExpand(textarea);
        }

        const categoriaSelect = document.getElementById('categoria');
        const productosCategoriaSelect = document.getElementById('productosCategoria');
        const vigilanciaDiv = document.getElementById('productos_vigilancia');
        const tecnicoDiv = document.getElementById('productos_tecnico');
        const form = document.getElementById('servicioForm');

        // Función para mostrar productos según la categoría seleccionada en "Productos requeridos"
        function updateProductVisibility() {
            const categoria = productosCategoriaSelect.value;
            vigilanciaDiv.classList.add('d-none');
            tecnicoDiv.classList.add('d-none');

            if (categoria === 'vigilancia') {
                vigilanciaDiv.classList.remove('d-none');
            } else if (categoria === 'tecnico') {
                tecnicoDiv.classList.remove('d-none');
            }
        }

        // Listener para el cambio en "Productos requeridos"
        productosCategoriaSelect.addEventListener('change', updateProductVisibility);

        // Al cargar la página, asegura que los productos se muestren si hay una selección previa
        // Esto es útil si se usa old() o se edita un servicio existente
        // También se asegura de que la categoría de productos se seleccione si se puede inferir del servicio
        const initialProductosCategoriaValue = productosCategoriaSelect.value;
        if (initialProductosCategoriaValue) {
            updateProductVisibility();
        } else {
            // Intenta inferir la categoría de productos del servicio si no hay old()
            const servicioCategoria = "{{ $servicio->categoria ?? '' }}";
            let inferredProductosCategoria = '';
            if (servicioCategoria === 'vigilancia' || servicioCategoria === 'Implementos de seguridad') {
                inferredProductosCategoria = 'vigilancia';
            } else if (servicioCategoria === 'tecnico' || ['Cámaras de seguridad', 'Alarmas antirrobo', 'Cerraduras inteligentes', 'Sensores de movimiento', 'Luces con sensor de movimiento', 'Rejas o puertas de seguridad', 'Sistema de monitoreo 24/7'].includes(servicioCategoria)) {
                inferredProductosCategoria = 'tecnico';
            }

            if (inferredProductosCategoria) {
                productosCategoriaSelect.value = inferredProductosCategoria;
                updateProductVisibility();
            }
        }


        // Validaciones input personalizados
        function validarInput(e, pattern, maxLength) {
            const input = e.target;
            let valor = input.value;
            let regex = new RegExp(pattern, 'g');
            let soloPermitidos = valor.match(regex);
            valor = soloPermitidos ? soloPermitidos.join('') : '';
            if (valor.length > maxLength) valor = valor.substring(0, maxLength);
            input.value = valor;
        }

        // Nombre y descripción: solo letras y espacios
        document.getElementById('nombreServicio').addEventListener('input', e => {
            validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 50);
        });

        document.getElementById('descripcionServicio').addEventListener('input', e => {
            validarInput(e, '[A-Za-zÁÉÍÓÚáéíóúÑñ\\s]', 125);
        });

        // Evitar espacio al inicio
        function bloquearEspacioAlInicio(e, input) {
            if (e.key === ' ' && input.selectionStart === 0) {
                e.preventDefault();
            }
        }

        // Validación al enviar formulario
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Resetear campos dinámicos
        form.addEventListener('reset', function () {
            vigilanciaDiv.classList.add('d-none');
            tecnicoDiv.classList.add('d-none');
            form.classList.remove('was-validated');

            // Desmarcar todos los checkboxes
            const checks = form.querySelectorAll('input[type="checkbox"]');
            checks.forEach(cb => cb.checked = false);

            productosCategoriaSelect.selectedIndex = 0;
            categoriaSelect.selectedIndex = 0; // También resetea la categoría principal
        });

    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
