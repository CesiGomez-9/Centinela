@extends('plantilla')
@section('titulo', 'Detalles de la factura')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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

    <div class="container py-1">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card">
                    <div class="card-header position-relative">
                        <h5 class="mb-0" style="font-size: 0.9rem;">
                            <i class="bi bi-receipt-cutoff me-2"></i>Detalles de la factura
                        </h5>
                        <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                            Creado {{ $factura->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><i class="bi bi-hash me-2"></i><strong>Número de Factura:</strong> {{ $factura->numero_factura }}</p>
                                <p><i class="bi bi-calendar-event me-2"></i><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</p>
                                <p><i class="bi bi-building me-2"></i><strong>Proveedor:</strong> {{ $factura->proveedor->nombre }}</p>
                                <p><i class="bi bi-wallet-fill me-2"></i><strong>Forma de Pago:</strong> {{ $factura->forma_pago }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-person-check-fill me-2"></i><strong>Responsable:</strong> {{ $factura->empleado->nombre }} {{ $factura->empleado->apellido }}</p>
                                <p><i class="bi bi-cash-stack me-2"></i><strong>Subtotal (Lps):</strong> {{ number_format($factura->subtotal, 2) }}</p>
                                <p><i class="bi bi-currency-dollar me-2"></i><strong>Impuestos (Lps):</strong> {{ number_format($factura->impuestos, 2) }}</p>
                                <p><i class="bi bi-basket me-2"></i><strong>Total Final (Lps):</strong> {{ number_format($factura->totalF, 2) }}</p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            @forelse ($factura->detalles as $detalle)
                                <div class="col-md-6 mb-3">
                                    <p><i class="bi bi-box me-2"></i><strong>Producto:</strong> {{ $detalle->producto }}</p>
                                    <p><i class="bi bi-tags me-2"></i><strong>Categoría:</strong> {{ $detalle->categoria }}</p>
                                    <p><i class="bi bi-currency-dollar me-2"></i><strong>Precio Compra:</strong> Lps {{ number_format($detalle->precio_compra, 2) }}</p>
                                    <p><i class="bi bi-stack me-2"></i><strong>Cantidad:</strong> {{ $detalle->cantidad }}</p>
                                    <p><i class="bi bi-percent me-2"></i><strong>IVA:</strong> {{ $detalle->iva }}%</p>
                                       </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted fst-italic">No hay productos agregados a esta factura.</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <small>Última actualización: {{ $factura->updated_at->diffForHumans() }}</small>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                    <a href="{{ route('facturas.index') }}" class="btn-return">
                        <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

