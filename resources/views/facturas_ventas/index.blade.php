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

    <!-- Botón de volver y buscador -->
        <form method="GET" action="{{ route('facturas_ventas.index') }}">
            <div class="row mb-4 g-2">
                <!-- Buscador -->
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input
                            type="text"
                            id="searchInput"
                            name="searchInput"
                            class="form-control"
                            maxlength="30"
                            placeholder="Buscar por número o fecha"
                            value="{{ request('searchInput') }}"
                            onkeydown="bloquearEspacioAlInicio(event, this)"
                            oninput="eliminarEspaciosIniciales(this)">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                <!-- Desde -->
                <div class="col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Desde</span>
                        <input type="date" name="fecha_inicio" id="fechaInicio" class="form-control"
                               value="{{ request('fecha_inicio') }}">
                    </div>
                </div>

                <!-- Botón Filtrar -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                </div>

                <!-- Botón Registrar factura -->
                <div class="col-md-2">
                    <a href="{{ route('facturas_ventas.create') }}" class="btn btn-sm btn-outline-dark w-100">
                        <i class="bi bi-pencil-square me-2"></i> Registrar factura
                    </a>
                </div>

                <!-- Segunda fila: Hasta y Limpiar -->
                <div class="offset-md-4 col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Hasta</span>
                        <input type="date" name="fecha_fin" id="fechaFin" class="form-control"
                               value="{{ request('fecha_fin') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('facturas_ventas.index') }}" class="btn btn-sm btn-secondary w-100">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
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

        {{ $facturas->links() }}

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');

        const hoy = new Date();

        // Obtener año y mes actual
        const year = hoy.getFullYear();
        const month = hoy.getMonth(); // 0-indexado (enero = 0)

        // Primer día del mes
        const primerDia = new Date(year, month, 1);
        // Último día del mes (día 0 del mes siguiente = último del actual)
        const ultimoDia = new Date(year, month + 1, 0);

        const formatoFecha = (fecha) => fecha.toISOString().split('T')[0];

        const minDate = formatoFecha(primerDia);
        const maxDate = formatoFecha(ultimoDia);

        // Establecer los límites
        if (fechaInicio) {
            fechaInicio.setAttribute('min', minDate);
            fechaInicio.setAttribute('max', maxDate);
        }
        if (fechaFin) {
            fechaFin.setAttribute('min', minDate);
            fechaFin.setAttribute('max', maxDate);
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
