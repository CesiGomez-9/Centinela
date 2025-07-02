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
        <i class="bi bi-file-text"></i> Listado de facturas de compra
    </h1>

    <div class="row mb-4 align-items-center">
        <div class="col-md-6 d-flex justify-content-start">
            <div class="w-100" style="max-width: 300px;">
                <div class="input-group">
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        maxlength="30"
                        placeholder="Buscar por número de factura"
                        onkeydown="bloquearEspacioAlInicio(event, this)"
                        oninput="eliminarEspaciosIniciales(this)">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <a href="{{ route('facturas.create') }}" class="btn btn-md btn-outline-dark">
                <i class="bi bi-pencil-square me-2"></i>Registrar nueva factura de compra
            </a>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Número Factura</th>
            <th>Categoría</th>
            <th>Cantidad</th>
            <th>Responsable</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody id="facturasTableBody">
        @forelse ($facturas as $factura)
            <tr class="factura-row">
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
                <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-primary">
                    <i class="bi bi-eye"></i> Ver
                </a>
                <td>
                    <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-sm btn-primary">
                        Ver
                    </a>
                </td>
            </tr>
        @empty
            <tr id="noProductsRow">
                <td colspan="5" class="text-center">No hay facturas registradas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $facturas->links() }}

    @if(session()->has('status'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

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

                    if (filtro === '' || numeroFactura.includes(filtro)) {
                        fila.style.display = '';
                        resultadosVisibles++;
                        if (filtro !== '') {
                            resaltarTexto(fila.querySelector('.factura-numeroFactura'), filtro);
                        } else {
                            quitarResaltado(fila.querySelector('.factura-numeroFactura'));
                        }
                    } else {
                        fila.style.display = 'none';
                    }
                });

                if (noProductsRow) {
                    noProductsRow.style.display = resultadosVisibles === 0 ? '' : 'none';
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

    <div class="d-flex justify-content mt-5">
        <a href="/" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-2"></i> Volver al Inicio
        </a>
    </div>

@endsection
