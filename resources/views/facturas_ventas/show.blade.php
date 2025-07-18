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

<!-- Estilo personalizado -->
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: url('https://www.transparenttextures.com/patterns/beige-paper.png') repeat fixed #f8f4ec;
        font-size: 16px;
    }

    .card {
        border: none;
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        background: #ffffff;
        min-height: 400px;
        max-width: 1000px;
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: scale(1.01);
    }

    .card-header {
        background-color: #0d1b2a;
        padding: 1.75rem 1.75rem;
        border-bottom: 4px solid #cda34f;
    }

    .card-header h5 {
        color: #ffffff;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .card-header small {
        color: #f0e6d2;
        font-size: 0.85rem;
    }

    .card-body {
        padding: 2.25rem 1.75rem;
        font-size: 1rem;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .card-body p {
        margin-bottom: 1.3rem;
        border-left: 4px solid #cda34f;
        padding-left: 0.75rem;
    }

    .card-body i {
        color: #1b263b;
    }

    .card-body strong {
        color: #0d1b2a;
        font-weight: 600;
    }

    .card-footer {
        background-color: #1b263b;
        padding: 0.9rem 1.5rem;
        border-top: 1px solid #cda34f;
        font-size: 0.9rem;
    }

    .card-footer small {
        color: #f5f5f5;
    }

    .btn-return {
        background-color: #cda34f;
        color: #ffffff;
        border: none;
        padding: 0.7rem 1.6rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-size: 1rem;
        margin: 0 0.5rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-return:hover, .btn-return:focus {
        background-color: #0d1b2a;
        color: #ffffff;
        text-decoration: none;
    }

    @media (max-width: 767.98px) {
        .card-body {
            padding: 1.75rem 1rem;
            font-size: 0.95rem;
        }

        .btn-return {
            display: block;
            width: 100%;
            margin: 0.5rem 0;
        }
    }

    .section-header {
        margin-top: 2rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #cda34f;
        color: #0d1b2a;
        font-weight: 700;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<!-- Contenido -->
<div class="container py-4">
    <h2>Factura #{{ $factura->numero }}</h2>
    <p><strong>Cliente:</strong> {{ $factura->cliente->nombre ?? 'N/A' }}</p>
    <p><strong>Fecha:</strong> {{ $factura->fecha->format('d-m-Y') }}</p>
    <p><strong>Responsable:</strong> {{ $factura->empleado->nombre ?? 'N/A' }}</p>

    <h4>Productos en la Factura</h4>
    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-light sticky-top">
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio (Lps)</th>
                <th>Cantidad</th>
                <th>IVA %</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($factura->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->nombre }}</td>
                    <td>{{ $detalle->categoria }}</td>
                    <td>{{ number_format($detalle->precio_venta, 2) }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->iva }}</td>
                    <td>{{ number_format($detalle->subtotal, 2) }}</td>
                    <td>
                        <a href="{{ route('productos.show', $detalle->producto_id) }}" class="btn btn-sm btn-info">
                            Ver Detalle Producto
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <p><strong>Subtotal:</strong> Lps. {{ number_format($factura->subtotal, 2) }}</p>
    <p><strong>Impuestos:</strong> Lps. {{ number_format($factura->impuestos, 2) }}</p>
    <p><strong>Total:</strong> Lps. {{ number_format($factura->total, 2) }}</p>

    <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Volver a Factura</button>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
