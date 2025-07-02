@extends('layouts.plantilla')
@section('titulo', 'Listado de facturas')
@section('content')

    <style>
        table {
            width: 100%;
            border-collapse: collapse;

        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #090909;
            text-align: center;
        }

    </style>

    <h1 class="text-center mb-4" style="color: #09457f;">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <i class="bi bi-file-text"></i>Listado de facturas de compra
    </h1>


    <!-- Botón de volver y buscador -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 d-flex justify-content-start">
            <div class="w-100" style="max-width: 300px;">
                <div class="input-group">
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        maxlength="30"
                        placeholder="Buscar por nombre"
                        onkeydown="bloquearEspacioAlInicio(event, this)"
                        oninput="eliminarEspaciosIniciales(this)">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <a href="{{ route('facturas.create') }}" class="btn btn-md btn-outline-dark btn-md">
                <i class="bi bi-pencil-square me-2"></i>Registrar una nueva factura de compra
            </a>
        </div>
    </div>


    @if(session()->has('status'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong></strong>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <!-- Mensaje de resultados -->
    <div id="searchResults" class="mb-3"></div>
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark text-center">
        <tr>
            <th>#</th> <!-- Columna de enumeración -->
            <th>Número Factura</th>
            <th>Categoría</th>
            <th>Cantidad</th>
            <th>Responsable</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody id="facturasTableBody">
        @forelse ($facturas as $index => $factura)
            <tr class="factura-row">
                <td>{{ $index + 1 }}</td> <!-- Enumeración -->
                <td class="factura-numeroFactura">{{ $factura->numero_factura }}</td>
                <td>{{ $factura->categoria ?? 'N/A' }}</td>
                <td>{{ $factura->cantidad ?? 'N/A' }}</td>
                <td>
                    @if($factura->empleado)
                        {{ $factura->empleado->nombre }} {{ $factura->empleado->apellido }}
                    @else
                        No asignado
                    @endif
                </td>
                <td>
                    <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-outline-info btn-sm">Ver</a>
                </td>
            </tr>
        @empty
            <tr id="noProductsRow">
                <td colspan="6" class="text-center">No hay facturas registradas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const filas = document.querySelectorAll('.factura-row');
            const noProductsRow = document.getElementById('noProductsRow');

            searchInput.addEventListener('input', function () {
                const filtro = this.value.toLowerCase().trim();
                let resultadosVisibles = 0;

                filas.forEach(fila => {
                    // Buscar en la columna "Nombre" (3ra columna, índice 2 en nth-child porque empieza en 1)
                    const nombre = fila.querySelector('.factura-numeroFactura').textContent.toLowerCase();

                    if (filtro === '' || nombre.includes(filtro)) {
                        fila.style.display = '';
                        resultadosVisibles++;

                        // Resaltar texto encontrado si hay búsqueda
                        if (filtro !== '') {
                            resaltarTexto(fila.querySelector('.factura-numeroFactura'), filtro);
                        } else {
                            quitarResaltado(fila.querySelector('.factura-numeroFactura'));
                        }
                    } else {
                        fila.style.display = 'none';
                    }
                });

                // Mostrar mensaje de resultados
                mostrarResultados(filtro, resultadosVisibles);

                // Ocultar/mostrar mensaje de "no hay productos" según corresponda
                if (noProductsRow) {
                    if (filtro === '') {
                        noProductsRow.style.display = filas.length === 0 ? '' : 'none';
                    } else {
                        noProductsRow.style.display = 'none';
                    }
                }
            });
        });

        function resaltarTexto(elemento, termino) {
            const textoOriginal = elemento.getAttribute('data-original') || elemento.textContent;

            if (!elemento.getAttribute('data-original')) {
                elemento.setAttribute('data-original', textoOriginal);
            }

            const regex = new RegExp(`(${escapeRegex(termino)})`, 'gi');
            const textoResaltado = textoOriginal.replace(regex, '<mark style="background-color: #ffeb3b; padding: 2px;">$1</mark>');
            elemento.innerHTML = textoResaltado;
        }

        function quitarResaltado(elemento) {
            const textoOriginal = elemento.getAttribute('data-original');
            if (textoOriginal) {
                elemento.textContent = textoOriginal;
            }
        }

        function escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function mostrarResultados(termino, cantidad) {
            const searchResults = document.getElementById('searchResults');

            if (termino === '') {
                searchResults.innerHTML = '';
                return;
            }

            if (cantidad === 0) {
                searchResults.innerHTML = `
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        No se encontraron facturas con ese numero de factura "<strong>${termino}</strong>"
                    </div>
                `;
            } else {
                searchResults.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        Se encontraron <strong>${cantidad}</strong> factura(s) con ese numero de factura "<strong>${termino}</strong>"
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
            // Si pega un texto largo, lo limita a 30 caracteres
            if (input.value.length > 30) {
                input.value = input.value.substring(0, 30);
            }
        }
    </script>

    <div class="d-flex justify-content mt-5">
        <a href="/" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-2"></i> Volver al Inicio
        </a>
    </div>

    {{ $facturas->links() }}

@endsection
