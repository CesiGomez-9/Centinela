<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas de Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body style="background-color: #e6f0ff;">
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="#">
            <img src="{{ asset('seguridad/logo.jpg') }}" style="height:80px; margin-right: 10px;" alt="Logo Grupo Centinela">
            Grupo Centinela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

<div class="container my-5">
    <div class="card shadow p-4" style="background-color: #ffffff;">
        <h3 class="text-center mb-4" style="color: #09457f;">
            <i class="bi bi-file-text"></i> Listado de facturas de venta
        </h3>

        <!-- Buscador y botón -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6 d-flex justify-content-start">
                <div class="w-100" style="max-width: 300px;">
                    <div class="input-group">
                        <input
                            type="text"
                            id="searchInput"
                            class="form-control"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar por número, fecha, cliente o responsable"
                            onkeydown="bloquearEspacioAlInicio(event, this)"
                            oninput="eliminarEspaciosIniciales(this)">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a href="{{ route('facturas_ventas.create') }}" class="btn btn-md btn-outline-dark">
                    <i class="bi bi-pencil-square me-2"></i>Registrar una nueva factura de venta
                </a>
            </div>
        </div>

        @if(session()->has('status'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Número Factura</th>
                <th>Fecha</th>
                <th>Subtotal</th>
                <th>Impuestos</th>
                <th>Total</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="facturasVentasTableBody">
            @forelse ($facturas as $index => $factura)
                <tr class="factura-venta-row">
                    <td>{{ $index + 1 }}</td>
                    <td class="factura-numeroFactura">{{ $factura->numero }}</td>
                    <td class="factura-fecha">{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>
                    <td class="factura-subtotal">L. {{ number_format($factura->subtotal, 2) }}</td>
                    <td class="factura-impuestos">L. {{ number_format($factura->impuestos, 2) }}</td>
                    <td class="factura-total">L. {{ number_format($factura->total, 2) }}</td>
                    <td>{{ $factura->cliente->nombre ?? 'No asignado' }}</td>
                    <td>
                        <a href="{{ route('facturas_ventas.show', $factura->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('facturas_ventas.edit', $factura->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr id="noFacturasRow">
                    <td colspan="8" class="text-center">No hay facturas de venta registradas.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Mensajes de búsqueda --}}
        @if(request('search') && $facturas->total() > 0)
            <div class="mb-3 text-muted">
                Mostrando {{ $facturas->count() }} de {{ $facturas->total() }} resultados para:
                "<strong>{{ request('search') }}</strong>".
            </div>
        @elseif(request('search') && $facturas->total() === 0)
            <div class="mb-3 text-danger">
                No se encontraron resultados para "<strong>{{ request('search') }}</strong>".
            </div>
        @endif

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $facturas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');

        if (searchInput.value !== '') {
            searchInput.focus();
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }

        let timeout = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const search = this.value;
                const url = new URL(window.location.href);
                url.searchParams.set('search', search);
                window.location.href = url.toString();
            }, 700);
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
