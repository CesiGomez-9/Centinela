@extends('plantilla')
@section('titulo', 'Factura de Compra')
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
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .card-header h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.4rem;
            text-align: center;
            flex-grow: 0;
            margin-left: 0;
        }

        .card-header small {
            color: #f0e6d2;
            font-size: 0.85rem;
            position: absolute;
            top: 50%;
            right: 1.75rem;
            transform: translateY(-50%);
        }

        .card-body {
            padding: 2.25rem 1.75rem;
            font-size: 1rem;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .card-body p {
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
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

            .card-header .logo-container {
                position: static;
                transform: none;
                margin-bottom: 10px;
                justify-content: center;
            }

            .card-header h5 {
                margin-left: 0;
                text-align: center;
            }

            .card-header small {
                position: static;
                transform: none;
                text-align: center;
                display: block;
                margin-top: 5px;
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
            justify-content: center;
        }

        .invoice-header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            align-items: stretch;
            gap: 20px;
        }

        @media (max-width: 767.98px) {
            .invoice-header-info {
                flex-direction: column;
            }
        }

        .invoice-header-info .company-details,
        .invoice-header-info .invoice-details {
            flex: 1;
            min-width: 280px;
            padding: 15px 20px;
            border-radius: 8px;
            background-color: #fdfdfd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .company-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            gap: 10px;
        }

        .logo-and-name {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 5px;
        }

        .company-details img {
            max-width: 120px;
            height: auto;
            border-radius: 5px;
            flex-shrink: 0;
        }

        .company-details strong {
            font-size: 1.1rem;
            display: block;
            margin-bottom: 0;
        }

        .company-address-contact p {
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
        }

        .invoice-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            text-align: left;
        }

        .invoice-details .invoice-details-grid {
            display: block;
            width: 100%;
        }

        .invoice-details .invoice-details-grid > div {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .invoice-details .invoice-details-grid strong {
            display: inline;
            margin-right: 5px;
        }

        .product-table-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-table-container table {
            margin-bottom: 0;
        }

        .product-table-container th,
        .product-table-container td {
            font-size: 0.9rem;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .product-table-container thead th {
            background-color: #f2f2f2;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #cda34f;
        }

        .product-table-container tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product-table-container tbody tr:hover {
            background-color: #e6f0ff;
        }

        .invoice-summary-totals {
            margin-top: 2rem;
            display: flex;
            justify-content: flex-end;
        }

        .invoice-summary-totals .summary-box {
            width: 100%;/* Ancho máximo para la caja de resumen */
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            background-color: #fdfdfd;
        }

        .invoice-summary-totals .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.875rem;
        }

        .invoice-summary-totals .summary-item strong {
            color: #0d1b2a;
            font-weight: 600;
        }

        .invoice-summary-totals .summary-item span {
            font-weight: 500;
            color: #333;
            font-size: 0.875rem;
        }

        .invoice-summary-totals .summary-item.total {
            font-size: 1rem;
            font-weight: 700;
            border-top: 2px solid #cda34f;
            padding-top: 10px;
            margin-top: 15px;
        }
    </style>

    <div class="container py-1">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card">
                    <div class="card-header position-relative">
                        <h5 class="mb-0">
                            <i class="bi bi-receipt-cutoff me-2"></i>Factura de Compra
                        </h5>
                        <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                            Creado {{ $factura->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="invoice-header-info">
                            <div class="company-details">
                                <div class="logo-and-name">
                                    <img src="{{ asset('centinela.jpg') }}" alt="Logo de la Empresa Centinela">
                                    <strong>GRUPO CENTINELA</strong>
                                </div>
                                <div class="company-address-contact">
                                    <p>RTN: 06021999123456.</p>
                                    <p>Dirección: Barrio Oriental, cuatro cuadras al sur del parque central, Danlí, El Paraíso, Honduras.</p>
                                    <p>Teléfono fijo: +504 2763-3585.</p>
                                    <p>Teléfono celular: +504 9322-5352.</p>
                                    <p>Email: grupocentinela.hn@gmail.com.</p>
                                </div>
                            </div>
                            <div class="invoice-details">
                                <div class="invoice-details-grid">
                                    <div><strong>Factura de compra N°:</strong> {{ $factura->numero_factura }}.</div>
                                    <div><strong>Fecha comprobante:</strong> {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}.</div>
                                    <div><strong>Proveedor:</strong> {{ $factura->proveedor->nombreEmpresa }}.</div>
                                    <div><strong>Forma de pago:</strong> {{ $factura->forma_pago }}.</div>
                                    <div><strong>Responsable:</strong> {{ $factura->empleado->nombre }} {{ $factura->empleado->apellido }}.</div>
                                </div>
                            </div>
                        </div>

                        <h6 class="section-header">
                            Productos comprados
                        </h6>

                        <div class="table-responsive product-table-container">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Descripción</th>
                                    <th>Precio(Lps)</th>
                                    <th>Cantidad</th>
                                    <th>IVA%</th>
                                    <th>Subtotal(Lps)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($factura->detalles as $index => $detalle)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detalle->producto }}</td>
                                        <td>{{ number_format($detalle->precio_compra, 2) }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>{{ $detalle->iva }}%</td>
                                        <td>{{ number_format($detalle->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted fst-italic py-3">No hay productos agregados a esta factura.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="invoice-summary-totals">
                            <div class="summary-box">
                                <div class="summary-item">
                                    <strong>Importe Gravado (Lps):</strong>
                                    <span>{{ number_format($factura->importe_gravado, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Importe Exento (Lps):</strong>
                                    <span>{{ number_format($factura->importe_exento, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Importe Exonerado (Lps):</strong>
                                    <span>{{ number_format($factura->importe_exonerado, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Subtotal (Lps):</strong>
                                    <span>{{ number_format($factura->subtotal, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>ISV 15% (Lps):</strong>
                                    <span>{{ number_format($factura->isv_15, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>ISV 18% (Lps):</strong>
                                    <span>{{ number_format($factura->isv_18, 2) }}</span>
                                </div>
                                <div class="summary-item total">
                                    <strong>Total Final (Lps):</strong>
                                    <span>{{ number_format($factura->totalF, 2) }}</span>
                                </div>
                            </div>
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
