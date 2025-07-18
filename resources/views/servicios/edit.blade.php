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
    <div class="form-contenedor">
        <h2 class="text-center mb-4 text-primary fs-3">
            <i class="bi bi-pencil-square me-2"></i> Editar servicio
        </h2>

        <form id="servicioForm" action="{{ route('servicios.update', $servicio->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            {{-- Para restablecer valores originales --}}
            <input type="hidden" id="originalData" value="{{ htmlspecialchars(json_encode($servicio), ENT_QUOTES, 'UTF-8') }}">

            @php
                $productosSeleccionados = json_decode($servicio->productos ?? '[]', true);
                if (!is_array($productosSeleccionados)) {
                    $productosSeleccionados = [];
                }

                $duracion = explode(' ', $servicio->duracion_estimada ?? '');
                $duracionCantidad = $duracion[0] ?? '';
                $duracionTipo = $duracion[1] ?? '';
            @endphp

            <div class="col-md-6">
                    <label for="nombreServicio" class="form-label fs-5">Nombre del servicio</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <input type="text" id="nombreServicio" name="nombreServicio" class="form-control form-control-lg"
                               value="{{ old('nombreServicio', $servicio->nombre) }}"
                               maxlength="50" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" required />
                        <div class="invalid-feedback">Ingrese un nombre válido (solo letras).</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="descripcionServicio" class="form-label fs-5">Descripción</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-textarea-t"></i></span>
                        <textarea id="descripcionServicio" name="descripcionServicio" class="form-control form-control-lg"
                                  maxlength="125" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                  rows="1" style="overflow:hidden; resize:none;" required>{{ old('descripcionServicio', $servicio->descripcion) }}</textarea>
                        <div class="invalid-feedback">Ingrese una descripción válida.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="costo" class="form-label fs-5">Costo estimado (L)</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                        <input type="text" class="form-control form-control-lg" id="costo" name="costo"
                               value="{{ old('costo', $servicio->costo) }}"
                               pattern="^[1-9][0-9]{0,3}$" maxlength="4" required />

                        <div class="invalid-feedback">Ingrese un costo válido.</div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <label class="form-label fs-5">Duración estimada</label>
                    <div class="input-group input-group-lg">
                        @php
                            $duracion = explode(' ', $servicio->duracion_estimada);
                            $duracionCantidad = $duracion[0] ?? '';
                            $duracionTipo = $duracion[1] ?? '';
                        @endphp
                        <span class="input-group-text"><i class="bi bi-hourglass-split"></i></span>
                        <input type="number" class="form-control form-control-lg" id="duracionCantidad" name="duracion_cantidad"
                               min="1" max="99" value="{{ old('duracion_cantidad', $duracionCantidad) }}" required />

                        <select class="form-select form-select-lg" id="duracionTipo" name="duracion_tipo" required>
                            <option value="">Unidad</option>
                            <option value="horas" {{ old('duracion_tipo', $duracionTipo) == 'horas' ? 'selected' : '' }}>Horas</option>
                            <option value="dias" {{ old('duracion_tipo', $duracionTipo) == 'dias' ? 'selected' : '' }}>Días</option>
                            <option value="meses" {{ old('duracion_tipo', $duracionTipo) == 'meses' ? 'selected' : '' }}>Meses</option>
                            <option value="años" {{ old('duracion_tipo', $duracionTipo) == 'años' ? 'selected' : '' }}>Años</option>
                        </select>
                        <div class="invalid-feedback">Ingrese una duración válida.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="categoria" class="form-label fs-5">Categoría</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-ui-checks"></i></span>
                        <select class="form-select form-select-lg" id="categoria" name="categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <option value="vigilancia" {{ old('categoria', $servicio->categoria) == 'vigilancia' ? 'selected' : '' }}>Vigilancia</option>
                            <option value="tecnico" {{ old('categoria', $servicio->categoria) == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        </select>
                        <div class="invalid-feedback">Seleccione una categoría.</div>
                    </div>
                </div>

                @php
                    $productosSeleccionados = json_decode($servicio->productos ?? '[]', true);
                    if (!is_array($productosSeleccionados)) {
                        $productosSeleccionados = [];
                    }
                @endphp

                    <!-- Productos de vigilancia -->
                <div class="col-md-12 {{ old('categoria', $servicio->categoria) == 'vigilancia' ? '' : 'd-none' }}" id="productos_vigilancia">
                    <label class="form-label fs-5">Productos de vigilancia</label>

                    <input class="form-check-input"
                           type="checkbox"
                           name="productos_vigilancia[]"
                           value="{{ $producto }}"
                           id="vig_{{ Str::slug($producto, '_') }}"
                        {{ in_array($producto, $productosSeleccionados) ? 'checked' : '' }}>
                    ...

                    <div class="col-md-12 {{ old('categoria', $servicio->categoria) == 'vigilancia' ? '' : 'd-none' }}" id="productos_vigilancia">
                        <label class="form-label fs-5">Productos de vigilancia</label>
                        <div class="row">
                            @php
                                $productosVigilancia = [
                                    'Cinturón táctico', 'Radio de comunicación (walkie-talkie)', 'Linterna',
                                    'Cuaderno o libreta de bitácora', 'Bolígrafo o lápiz', 'Silbato',
                                    'Toner o bastón', 'Esposas', 'Chaleco antibalas', 'Botas reforzadas'
                                ];
                            @endphp
                            @foreach($productosVigilancia as $producto)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="productos_vigilancia[]"
                                               value="{{ $producto }}"
                                               id="vig_{{ Str::slug($producto, '_') }}"
                                            {{ in_array($producto, $productosSeleccionados) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vig_{{ Str::slug($producto, '_') }}">
                                            {{ $producto }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12 {{ old('categoria', $servicio->categoria) == 'tecnico' ? '' : 'd-none' }}" id="productos_tecnico">
                        <label class="form-label fs-5">Productos técnicos</label>
                        <div class="row">
                            @php
                                $productosTecnicos = [
                                    'Cámara IP Full HD', 'Cámara Bullet 4K', 'Cámara domo PTZ', 'Cámara térmica portátil', 'Cámara con visión nocturna',
                                    'Alarma inalámbrica', 'Alarma con sirena', 'Alarma de puerta y ventana', 'Sistema de alarma GSM', 'Alarma con detector de humo',
                                    'Cerradura biométrica', 'Cerradura con teclado', 'Cerradura Bluetooth', 'Cerradura con control remoto', 'Cerradura electrónica para puertas',
                                    'Sensor PIR inalámbrico', 'Sensor de movimiento con cámara', 'Sensor de movimiento para interiores', 'Sensor de movimiento con alarma', 'Sensor doble tecnología',
                                    'Luz LED con sensor', 'Luz solar con sensor', 'Foco exterior con sensor', 'Luz para jardín con sensor', 'Lámpara de seguridad con sensor',
                                    'Reja metálica reforzada', 'Puerta de seguridad con cerradura', 'Reja plegable de acero', 'Puerta blindada residencial', 'Reja corrediza automática',
                                    'Casco de seguridad', 'Guantes tácticos', 'Botas reforzadas', 'Escalera', 'Caja de herramientas'
                                ];
                            @endphp
                            @foreach($productosTecnicos as $producto)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="productos_tecnico[]"
                                               value="{{ $producto }}"
                                               id="tec_{{ Str::slug($producto, '_') }}"
                                            {{ in_array($producto, $productosSeleccionados) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tec_{{ Str::slug($producto, '_') }}">
                                            {{ $producto }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <!-- Botones -->
                <div class="text-center mt-5">
                    <a href="{{ route('servicios.catalogo') }}" class="btn btn-danger me-2">
                        <i class="bi bi-x-circle me-2"></i> Cancelar
                    </a>

                    <button type="button" class="btn btn-warning me-2" onclick="restablecerFormulario()">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Restablecer
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save-fill me-2"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    // Mostrar productos según la categoría seleccionada
    function mostrarProductosPorCategoria() {
        const categoria = document.getElementById('categoria').value;
        const tecnico = document.getElementById('productos_tecnico');
        const vigilancia = document.getElementById('productos_vigilancia');

        if (categoria === 'tecnico') {
            tecnico.classList.remove('d-none');
            vigilancia.classList.add('d-none');
        } else if (categoria === 'vigilancia') {
            vigilancia.classList.remove('d-none');
            tecnico.classList.add('d-none');
        } else {
            tecnico.classList.add('d-none');
            vigilancia.classList.add('d-none');
        }
    }

    // Activar visualmente productos al cambiar la categoría
    document.getElementById('categoria').addEventListener('change', mostrarProductosPorCategoria);

    // Ejecutar al cargar para prellenar campos correctamente
    window.addEventListener('DOMContentLoaded', () => {
        mostrarProductosPorCategoria();

        // Forzar selección visual en duración
        const data = JSON.parse(document.getElementById('originalData').value);
        const [cantidad, tipo] = data.duracion_estimada.split(' ');

        document.getElementById('duracionCantidad').value = cantidad || '';
        document.getElementById('duracionTipo').value = tipo || '';
    });

    // Slugify: para transformar texto en IDs seguros
    function slugify(s) {
        return s.toLowerCase()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // quitar tildes
            .replace(/[^a-z0-9]+/g, '_');
    }

    // Botón restablecer
    function restablecerFormulario() {
        const data = JSON.parse(document.getElementById('originalData').value);

        document.getElementById('nombreServicio').value = data.nombre;
        document.getElementById('descripcionServicio').value = data.descripcion;
        document.getElementById('costo').value = data.costo;

        const [cantidad, tipo] = data.duracion_estimada.split(' ');
        document.getElementById('duracionCantidad').value = cantidad;
        document.getElementById('duracionTipo').value = tipo;

        document.getElementById('categoria').value = data.categoria;
        document.getElementById('categoria').dispatchEvent(new Event('change'));

        // Limpiar checks
        document.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = false);
        try {
            const productos = JSON.parse(data.productos);
            productos.forEach(p => {
                const idV = 'vig_' + slugify(p);
                const idT = 'tec_' + slugify(p);
                const check = document.getElementById(idV) || document.getElementById(idT);
                if (check) check.checked = true;
            });
        } catch (e) {
            console.warn("No se pudieron restablecer los productos");
        }

        document.getElementById('servicioForm').classList.remove('was-validated');
    }
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
