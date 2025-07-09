@extends('plantilla')
@section('titulo', 'Listado de productos')
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
        <i class="bi bi-boxes me-2"></i>Inventario de productos
    </h1>

    <!-- Botón de buscador -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 d-flex justify-content-start">
            <div class="w-100" style="max-width: 300px;">
                <div class="input-group">
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        maxlength="30"
                        placeholder="Buscar por serie"
                        onkeydown="bloquearEspacioAlInicio(event, this)"
                        oninput="eliminarEspaciosIniciales(this)"
                    >
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <a href="{{ route('productos.create') }}" class="btn btn-md btn-outline-dark btn-md">
                <i class="bi bi-pencil-square me-2"></i>Registrar un nuevo producto
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

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
            <tr>
                <th>#</th> {{-- Enumeración --}}
                <th>Serie</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Categoria</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="productosTableBody">
            @forelse($productos as $producto)
                <tr class="producto-row">
                    <td>{{ $loop->iteration }}</td> {{-- Enumeración automática --}}
                    <td>{{ $producto->serie }}</td>
                    <td>{{ $producto->codigo }}</td>
                    <td class="producto-nombre">{{ $producto->nombre }}</td>
                    <td>{{ $producto->marca }}</td>
                    <td>{{ $producto->modelo }}</td>
                    <td>{{ $producto->categoria }}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>
                        <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-outline-info btn-sm">Ver</a>
                    </td>
                </tr>
            @empty
                <tr id="noProductsRow">
                    <td colspan="9" class="text-center">No hay productos registrados.</td>
                </tr>
            @endforelse
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
            // Obtener todas las celdas de la fila
            const celdas = fila.querySelectorAll('td');
            const serie = celdas[1].textContent.toLowerCase(); // segunda celda
            const codigo = celdas[2].textContent.toLowerCase(); // tercera celda
            const nombre = celdas[3].textContent.toLowerCase(); // cuarta celda

            if (
            filtro === '' ||
            serie.includes(filtro) ||
            codigo.includes(filtro) ||
            nombre.includes(filtro)
            ) {
            fila.style.display = '';
            resultadosVisibles++;

            if (filtro !== '') {
            resaltarTexto(celdas[1], filtro); // Resaltar serie
            resaltarTexto(celdas[2], filtro); // Resaltar código
            resaltarTexto(celdas[3], filtro); // Resaltar nombre
        } else {
            quitarResaltado(celdas[1]);
            quitarResaltado(celdas[2]);
            quitarResaltado(celdas[3]);
        }
        } else {
            fila.style.display = 'none';
        }
        });

            // Mostrar mensaje de resultados
            mostrarResultados(filtro, resultadosVisibles);

            // Mostrar/ocultar fila "no hay productos"
            if (noProductsRow) {
            if (filtro === '') {
            noProductsRow.style.display = filas.length === 0 ? '' : 'none';
        } else {
            noProductsRow.style.display = resultadosVisibles === 0 ? '' : 'none';
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
            elemento.removeAttribute('data-original');
        }
        }

            function escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

            function mostrarResultados(termino, cantidad) {
                const searchResults = document.getElementById('searchResults');
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

    {{ $productos->links() }}

@endsection
