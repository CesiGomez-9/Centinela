@extends('plantilla')
@section('content')
<style>
    .table-bordered {
        border: 1px solid #dee2e6 !important;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6 !important;
    }

</style>

<div class="container my-5">
    <div class="card shadow p-4" style="background-color: #ffffff;">
        <h3 class="text-center mb-4" style="color: #09457f;">
            <i class="bi bi-file-text"></i> Listado de facturas de venta
        </h3>

        <form method="GET" action="{{ route('facturas_ventas.index') }}">
            <div class="row mb-4 g-2 d-flex flex-wrap align-items-start">

                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input
                            type="text"
                            id="searchInput"
                            name="searchInput"
                            class="form-control"
                            maxlength="30"
                            placeholder="Buscar por número de factura y cliente..."
                            value="{{ request('searchInput') }}"
                            onkeydown="bloquearEspacioAlInicio(event, this)"
                            oninput="eliminarEspaciosIniciales(this)">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
                <div class="col-md-2 ms-4 d-flex flex-column gap-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Desde</span>
                        <input type="date" name="fecha_inicio" id="fechaInicio" class="form-control"
                               value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Hasta</span>
                        <input type="date" name="fecha_fin" id="fechaFin" class="form-control"
                               value="{{ request('fecha_fin') }}">
                    </div>
                </div>
                <div class="col-md-2 ms-3 d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('facturas_ventas.index') }}" class="btn btn-sm btn-secondary w-100">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>
                <div class="col-md-3 ms-auto">
                    <a href="{{ route('facturas_ventas.create') }}"  class="btn btn-md btn-outline-primary w-80">
                        <i class="bi bi-pencil-square me-1"></i> Registrar factura de venta
                    </a>
                </div>
            </div>
        </form>
        @if(session()->has('status'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Número de factura</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Forma de pago</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="facturasVentasTableBody">
            @forelse ($facturas as $index => $factura)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="max-width: 150px; word-wrap: break-word; white-space: normal;">
                        {{ $factura->numero }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>
                    <td style="max-width: 200px; word-wrap: break-word; white-space: normal;">
                        {{ $factura->cliente->nombre ?? 'No asignado' }}
                    </td>
                    <td>{{ ucfirst($factura->forma_pago) }}</td>
                    <td>L. {{ number_format($factura->total, 2) }}</td>
                    <td class="text-center">
                        <a href="{{ route('facturas_ventas.show', $factura->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye me-1"></i> Ver
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay facturas de venta registradas.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $facturas->links() }}
        </div>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const hoy = new Date();
        const formatoFecha = (fecha) => fecha.toISOString().split('T')[0];

        const fechaMinima = new Date("{{ $fechaMinima ?? \Carbon\Carbon::now()->toDateString() }}");
        const minDate = formatoFecha(fechaMinima);
        const maxDate = formatoFecha(hoy);

        if (fechaInicio) {
            fechaInicio.setAttribute('min', minDate);
            fechaInicio.setAttribute('max', maxDate);
        }
        if (fechaFin) {
            fechaFin.setAttribute('min', minDate);
            fechaFin.setAttribute('max', maxDate);
        }
    });

    const searchInput = document.getElementById('searchInput');
    let timer;
    searchInput.addEventListener('input', function () {
        clearTimeout(timer);

        timer = setTimeout(() => {
            const form = searchInput.closest('form');
            form.submit();
        }, 500);
    });
</script>
@endsection
