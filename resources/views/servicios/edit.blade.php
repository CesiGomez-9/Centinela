@extends('plantilla')
@section('content')
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
            .is-invalid + .text-danger.small,
            .is-invalid + .invalid-feedback,
            .is-invalid ~ .text-danger {
                display: block !important;
            }
            #servicioForm {
                font-size: 0.85rem;
            }
        </style>
    </head>
    <body>

    <div class="container my-3">
        <div class="form-contenedor position-relative">
            <h2 class="text-center mb-4 text-primary fs-8">
                <i class="bi bi-journal-plus me-2"></i> Editar un servicio
            </h2>

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

                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-12 col-md-6">
                        <label for="nombreServicio" class="form-label fs-6 mb-2">Nombre del servicio</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" id="nombreServicio" name="nombreServicio"
                                   class="form-control @error('nombreServicio') is-invalid @enderror"
                                   maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$"
                                   title="Solo letras, números y espacios, máximo 50 caracteres"
                                   value="{{ old('nombreServicio', $servicio->nombre) }}"
                                   onkeydown="bloquearEspacioAlInicio(event, this)"
                                   oninput="eliminarEspaciosIniciales(this)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un nombre válido.</div>
                        </div>
                        @error('nombreServicio')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Costos -->
                    <div class="col-12 col-md-2">
                        <label for="costo_diurno" class="form-label fs-6 mb-2">Costo diurno</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-sun"></i></span>
                            <input type="number" step="0.01" min="1" max="9999"
                                   class="form-control @error('costo_diurno') is-invalid @enderror"
                                   id="costo_diurno" name="costo_diurno"
                                   value="{{ old('costo_diurno', $servicio->costo_diurno) }}"
                                   oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo diurno válido.</div>
                        </div>
                        @error('costo_diurno')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-2">
                        <label for="costo_nocturno" class="form-label fs-6 mb-2">Costo nocturno</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-moon"></i></span>
                            <input type="number" step="0.01" min="1" max="9999"
                                   class="form-control @error('costo_nocturno') is-invalid @enderror"
                                   id="costo_nocturno" name="costo_nocturno"
                                   value="{{ old('costo_nocturno', $servicio->costo_nocturno) }}"
                                   oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo nocturno válido.</div>
                        </div>
                        @error('costo_nocturno')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-2">
                        <label for="costo_24_horas" class="form-label fs-6 mb-2">Costo 24 horas</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            <input type="number" step="0.01" min="1" max="9999"
                                   class="form-control @error('costo_24_horas') is-invalid @enderror"
                                   id="costo_24_horas" name="costo_24_horas"
                                   value="{{ old('costo_24_horas', $servicio->costo_24_horas) }}"
                                   oninput="limitarDigitos(this, 4)" required />
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese un costo de 24 horas válido.</div>
                        </div>
                        @error('costo_24_horas')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descripción y categoría productos -->
                    <div class="col-12 col-md-6">
                        <label for="descripcionServicio" class="form-label fs-6 mb-2">Descripción</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                            <textarea id="descripcionServicio" name="descripcionServicio"
                                      class="form-control @error('descripcionServicio') is-invalid @enderror"
                                      maxlength="125" rows="1"
                                      onkeydown="bloquearEspacioAlInicio(event, this)"
                                      oninput="eliminarEspaciosIniciales(this); autoExpand(this);"
                                      style="overflow:hidden; resize:none;"
                                      required>{{ old('descripcionServicio', $servicio->descripcion) }}</textarea>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Ingrese una descripción válida.</div>
                        </div>
                        @error('descripcionServicio')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fs-6 mb-2">Productos requeridos</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                            <select id="productosCategoria" name="productos_categoria" class="form-select">
                                <option value="">Seleccione una categoría</option>
                                <option value="vigilancia" {{ old('productos_categoria', $servicio->categoria) === 'vigilancia' ? 'selected' : '' }}>Vigilancia</option>
                                <option value="tecnico" {{ old('productos_categoria', $servicio->categoria) === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                            </select>
                            <div class="invalid-feedback" style="font-size: 0.85rem;">Seleccione una categoría.</div>
                        </div>
                        @error('productos_categoria')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Checkboxes productos -->
                    <div class="col-12 d-none mt-2" id="productos_vigilancia">
                        <label class="form-label fw-semibold">Productos de vigilancia</label>
                        <div class="row row-cols-1 row-cols-md-2 g-1">
                            @foreach($productosVigilancia as $producto)
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto->id }}"
                                               id="vig_{{ Str::slug($producto->nombre, '_') }}"
                                            {{ in_array($producto->id, old('productos', $productosSeleccionados)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vig_{{ Str::slug($producto->nombre, '_') }}">
                                            {{ $producto->nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 d-none mt-2" id="productos_tecnico">
                        <label class="form-label fw-semibold">Productos técnicos</label>
                        <div class="row row-cols-1 row-cols-md-2 g-1">
                            @foreach($productosTecnicos as $producto)
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto->id }}"
                                               id="tec_{{ Str::slug($producto->nombre, '_') }}"
                                            {{ in_array($producto->id, old('productos', $productosSeleccionados)) ? 'checked' : '' }}>
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
                        <a href="{{ route('servicios.catalogo') }}" class="btn btn-danger me-2"><i class="bi bi-x-circle me-2"></i>Cancelar</a>
                        <button type="reset" class="btn btn-warning me-2"><i class="bi bi-eraser-fill me-2"></i>Restablecer</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill me-2"></i>Guardar Cambios</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function autoExpand(textarea){
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }

        function bloquearEspacioAlInicio(e, input){
            if(e.key === ' ' && input.selectionStart === 0) e.preventDefault();
        }

        function limitarDigitos(input, maxDigits){
            if(input.value.length > maxDigits) input.value = input.value.slice(0, maxDigits);
        }

        window.addEventListener('DOMContentLoaded', () => {
            const descripcion = document.getElementById('descripcionServicio');
            if(descripcion){
                autoExpand(descripcion);
                descripcion.addEventListener('input', ()=> autoExpand(descripcion));
            }

            const selectCategoria = document.getElementById('productosCategoria');
            const vigilanciaDiv = document.getElementById('productos_vigilancia');
            const tecnicoDiv = document.getElementById('productos_tecnico');

            function updateProductVisibility(){
                vigilanciaDiv.classList.add('d-none');
                tecnicoDiv.classList.add('d-none');
                if(selectCategoria.value === 'vigilancia') vigilanciaDiv.classList.remove('d-none');
                else if(selectCategoria.value === 'tecnico') tecnicoDiv.classList.remove('d-none');
            }

            // ✅ Mostrar productos seleccionados al cargar la página
            // Usa el valor actual del select (old() o $servicio->categoria)
            updateProductVisibility();

            selectCategoria.addEventListener('change', updateProductVisibility);

            const form = document.getElementById('servicioForm');
            form.addEventListener('submit', function(e){
                if(!form.checkValidity()){
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            form.addEventListener('reset', function(){
                vigilanciaDiv.classList.add('d-none');
                tecnicoDiv.classList.add('d-none');
                form.classList.remove('was-validated');
                form.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                selectCategoria.selectedIndex = 0;
            });
        });

    </script>
    </body>
@endsection
