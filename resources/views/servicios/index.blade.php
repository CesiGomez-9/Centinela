@extends('plantilla')
@section('content')

    <style>

        body{

            height: 100vh;
            margin: 0;
            background-color: #e6f0ff;
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
        #servicioForm {
            font-size: 0.85rem; /* 85% tamaño base */
        }
    </style>



    <body>


    <div class="container my-3">
        <div class="form-contenedor position-relative">
            <!-- Título e ícono izquierdo -->
            <h2 class="text-center mb-4 text-primary fs-8">
                <i class="bi bi-journal-plus me-2"></i> Registrar un nuevo servicio
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


            <form id="servicioForm" action="{{ route('servicios.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="row g-3">

                    <!-- Nombre del servicio (col-md-6) -->
                    <div class="col-12 col-md-6">
                        <label for="nombreServicio" class="form-label fs-6 mb-2">Nombre del servicio</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" id="nombreServicio" name="nombreServicio" class="form-control form-control-md"
                                   maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                   title="Solo letras, máximo 50 caracteres"
                                   onkeydown="bloquearEspacioAlInicio(event, this)"
                                   oninput="eliminarEspaciosIniciales(this)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un nombre válido (solo letras).</div>
                        </div>
                    </div>

                    <!-- Costo Diurno (col-md-2) -->
                    <div class="col-12 col-md-2">
                        <label for="costo_diurno" class="form-label fs-6 mb-2">Costo diurno</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-sun"></i></span>
                            <input type="number" step="0.01" class="form-control form-control-md" id="costo_diurno" name="costo_diurno"
                                   min="0" max="9999" oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo diurno válido.</div>
                        </div>
                    </div>

                    <!-- Costo Nocturno (col-md-2) -->
                    <div class="col-12 col-md-2">
                        <label for="costo_nocturno" class="form-label fs-6 mb-2">Costo nocturno</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-moon"></i></span>
                            <input type="number" step="0.01" class="form-control form-control-md" id="costo_nocturno" name="costo_nocturno"
                                   min="0" max="9999" oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo nocturno válido.</div>
                        </div>
                    </div>

                    <!-- Costo 24 Horas (col-md-2) -->
                    <div class="col-12 col-md-2">
                        <label for="costo_24_horas" class="form-label fs-6 mb-2">Costo 24 horas</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            <input type="number" step="0.01" class="form-control form-control-md" id="costo_24_horas" name="costo_24_horas"
                                   min="0" max="9999" oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo de 24 horas válido.</div>
                        </div>
                    </div>

                    <!-- Descripción (ocupa todo el ancho) -->
                    <div class="col-12">
                        <label for="descripcionServicio" class="form-label fs-6 mb-2">Descripción</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                            <textarea id="descripcionServicio" name="descripcionServicio" class="form-control form-control-md"
                                      maxlength="125" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                      onkeydown="bloquearEspacioAlInicio(event, this)"
                                      oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                      title="Solo letras, máximo 125 caracteres"
                                      rows="1" required
                                      style="overflow:hidden; resize:none;"></textarea>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese una descripción válida.</div>
                        </div>
                    </div>

                    <!-- Categoría y Productos requeridos juntos -->
                    <div class="col-md-6">
                        <label for="categoria" class="form-label fs-6 mb-2">Categoría</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-ui-checks"></i></span>
                            <select class="form-select form-select-md" id="categoria" name="categoria" required>
                                <option value="">Seleccione una categoría</option>
                                <option value="vigilancia">Vigilancia</option>
                                <option value="tecnico">Técnico</option>
                            </select>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Seleccione una categoría.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-6 mb-2">Productos requeridos</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                            <select class="form-select form-select-md" id="productosCategoria" name="productos_categoria" required>
                                <option value="">Seleccione una categoría</option>
                                <option value="vigilancia">Vigilancia</option>
                                <option value="tecnico">Técnico</option>
                            </select>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Seleccione una categoría de productos.</div>
                        </div>
                    </div>

                    <!-- Productos de vigilancia -->
                    <div class="col-12 d-none" id="productos_vigilancia">
                        <label class="form-label fs-6 mb-2">Productos de vigilancia</label>
                        <div class="row g-2" style="font-size: 0.85rem;">
                            @foreach($productosVigilancia as $producto)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto->id }}" id="vig_{{ Str::slug($producto->nombre, '_') }}">
                                        <label class="form-check-label" for="vig_{{ Str::slug($producto->nombre, '_') }}">
                                            {{ $producto->nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Productos técnicos -->
                    <div class="col-12 d-none" id="productos_tecnico">
                        <label class="form-label fs-6 mb-2">Productos técnicos</label>
                        <div class="row g-2" style="font-size: 0.85rem;">
                            @foreach($productosTecnico as $producto)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto->id }}" id="tec_{{ Str::slug($producto->nombre, '_') }}">
                                        <label class="form-check-label" for="tec_{{ Str::slug($producto->nombre, '_') }}">
                                            {{ $producto->nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
            autoExpand(textarea);
        });

        // Nueva función para limitar los dígitos antes del punto decimal
        function limitarDigitos(input, maxDigits) {
            let value = input.value;
            // Permite números, el punto decimal y hasta dos decimales
            let parts = value.split('.');
            if (parts[0].length > maxDigits) {
                parts[0] = parts[0].substring(0, maxDigits);
            }
            if (parts[1] && parts[1].length > 2) {
                parts[1] = parts[1].substring(0, 2);
            }
            input.value = parts.join('.');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const categoriaSelect = document.getElementById('categoria');
            const productosCategoriaSelect = document.getElementById('productosCategoria');
            const vigilanciaDiv = document.getElementById('productos_vigilancia');
            const tecnicoDiv = document.getElementById('productos_tecnico');
            const form = document.getElementById('servicioForm');

            // Mostrar productos según la categoría seleccionada
            productosCategoriaSelect.addEventListener('change', function () {
                const categoria = this.value;
                vigilanciaDiv.classList.add('d-none');
                tecnicoDiv.classList.add('d-none');

                if (categoria === 'vigilancia') {
                    vigilanciaDiv.classList.remove('d-none');
                } else if (categoria === 'tecnico') {
                    tecnicoDiv.classList.remove('d-none');
                }
            });

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
                autoExpand(e.target); // Asegura que se expanda al escribir
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

            });


            // Al cargar la página, sincroniza todo si ya hay una selección previa
            const selectedCategoria = categoriaSelect.value;
            if (selectedCategoria === 'vigilancia' || selectedCategoria === 'tecnico') {
                productosCategoriaSelect.value = selectedCategoria;
                productosCategoriaSelect.dispatchEvent(new Event('change'));
                categoriaSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>

    </body>
@endsection
