@extends('plantilla')
@section('titulo', 'Listado de facturas_compras')
@section('content')

    <style>


        body{
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }



    </style>
    <div class="container mt-5" style="max-width: 1100px;">
        <div class="card shadow p-4" style="background-color: #ffffff;">
            <h3 class="text-center mb-4" style="color: #09457f;">
        <i class="bi bi-file-text"></i>Listado de facturas de compra
            </h3>



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

                        placeholder="Buscar por numero de factura "

                        placeholder="Buscar por número o fecha"

                        onkeydown="bloquearEspacioAlInicio(event, this)"
                        oninput="eliminarEspaciosIniciales(this)">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <a href="{{ route('facturas_compras.create') }}" class="btn btn-sm btn-outline-primary mb-2">
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




            <table class="table table-bordered table-striped">
                <thead class="table-dark">
        <tr>
            <th>N°</th>
            <th>Número Factura</th>
            <th>Fecha de la factura</th>
            <th>Total de la factura</th>
            <th>Responsable</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody id="facturasTableBody">
        @forelse ($facturas as $index => $factura)
            <tr class="factura-row">
                <td>{{ $index + 1 }}</td>

                {{-- Número de factura --}}
                <td class="factura-numeroFactura">{{ $factura->numero_factura }}</td>

                {{-- Fecha de la factura --}}
                <td class="factura-fecha">{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>

                {{-- Total de la factura --}}
                <td class="factura-totalF">L. {{ number_format($factura->totalF, 2) }}</td>

                {{-- Responsable --}}
                <td>
                    @if($factura->empleado)
                        {{ $factura->empleado->nombre }} {{ $factura->empleado->apellido }}
                    @else
                        No asignado
                    @endif
                </td>

                {{-- Acciones --}}
                <td>
                    <a href="{{ route('facturas_compras.show', $factura->id) }}" class="btn btn-sm btn-outline-info">
                        <i class="bi bi-eye"></i> Ver
                    </a>
                </td>
            </tr>
        @empty
            <tr id="noProductsRow">
                <td colspan="6" class="text-center">No hay facturas registradas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
            <div id="searchResults" class="mb-3"></div>

            <div class="d-flex justify-content mt-5">
                <a href="/" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left me-2"></i> Volver al Inicio
                </a>
            </div>

        </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const filas = document.querySelectorAll('.factura-row');
            const noProductsRow = document.getElementById('noProductsRow');

            searchInput.addEventListener('input', function () {
                const filtro = this.value.toLowerCase().trim();
                let resultadosVisibles = 0;

                filas.forEach(fila => {
                    const numeroFactura = fila.querySelector('.factura-numeroFactura').textContent.toLowerCase();
                    const fecha = fila.querySelector('.factura-fecha').textContent.toLowerCase();
                    const total = fila.querySelector('.factura-totalF').textContent.toLowerCase();

                    if (filtro === '' || numeroFactura.includes(filtro) || fecha.includes(filtro) || total.includes(filtro)) {
                        fila.style.display = '';
                        resultadosVisibles++;

                        if (filtro !== '') {
                            resaltarTexto(fila.querySelector('.factura-numeroFactura'), filtro);
                            resaltarTexto(fila.querySelector('.factura-fecha'), filtro);
                            resaltarTexto(fila.querySelector('.factura-totalF'), filtro);
                        } else {
                            quitarResaltado(fila.querySelector('.factura-numeroFactura'));
                            quitarResaltado(fila.querySelector('.factura-fecha'));
                            quitarResaltado(fila.querySelector('.factura-totalF'));
                        }
                    } else {
                        fila.style.display = 'none';
                    }
                });

                mostrarResultados(filtro, resultadosVisibles);

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
            const totalFilas = document.querySelectorAll('.factura-row').length;

            if (termino === '') {
                searchResults.innerHTML = '';
                return;
            }

            if (cantidad === 0) {
                searchResults.innerHTML = `
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                No se encontraron facturas con el término "<strong>${termino}</strong>"
            </div>
        `;
            } else {
                searchResults.innerHTML = `
            <div>
                Mostrando <strong>${cantidad}</strong> de <strong>${totalFilas}</strong> facturas encontradas para "<strong>${termino}</strong>"
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

            if (input.value.length > 30) {
                input.value = input.value.substring(0, 30);
            }
        }
    </script>




    {{ $facturas->links() }}

@endsection
