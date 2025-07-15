@extends('plantilla')
@section('titulo', 'Detalles del producto')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('https://www.transparenttextures.com/patterns/beige-paper.png') repeat fixed #f8f4ec;
            font-size: 0.9rem; /* Unificado: Establece un tamaño de fuente base más pequeño */
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
            margin-bottom: 2rem; /* Espacio entre tarjetas */
        }

        .card:hover {
            transform: scale(1.01);
        }

        .card-header {
            background-color: #0d1b2a;
            padding: 1rem 1rem; /* Ajustado para consistencia */
            border-bottom: 3px solid #cda34f;
            display: flex; /* Asegura que los elementos del header estén en línea */
            justify-content: space-between; /* Espacia el título y la fecha de creación */
            align-items: center; /* Centra verticalmente los elementos */
        }

        .card-header .header-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1rem; /* Tamaño de fuente para el título principal del header, ajustado */
            margin-bottom: 0; /* Elimina el margen inferior predeterminado de h4 */
        }

        .card-header small {
            color: #ffffff; /* Color para el texto de "Creado hace..." */
            font-weight: 700;
            font-size: 0.8rem; /* HECHO MÁS PEQUEÑO */
            position: static; /* Elimina el posicionamiento absoluto para que fluya con flexbox */
            transform: none; /* Elimina la transformación */
            margin-left: auto; /* Empuja a la derecha en flexbox */
        }

        .card-body {
            padding: 2.25rem 1.75rem;
            font-size: 0.9rem; /* Unificado: Ahora hereda o es 0.9rem */
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .card-body p {
            margin-bottom: 1.3rem;
            border-left: 4px solid #cda34f;
            padding-left: 0.75rem;
            font-size: 0.9rem; /* Unificado: Ahora hereda o es 0.9rem */
        }

        .card-body i {
            color: #1b263b;
            font-size: 1rem; /* Iconos ligeramente más grandes para visibilidad */
        }

        .card-body strong {
            color: #0d1b2a;
            font-weight: 600;
        }

        .card-footer {
            background-color: #1b263b;
            padding: 0.9rem 1.5rem;
            border-top: 1px solid #cda34f;
        }

        .card-footer small {
            color: #f5f5f5;
            font-size: 0.8rem; /* HECHO MÁS PEQUEÑO */
        }

        .btn-return, .btn-edit {
            background-color: #cda34f;
            color: #ffffff;
            border: none;
            padding: 0.7rem 1.6rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem; /* Unificado: Ahora hereda o es 0.9rem */
            margin: 0 0.5rem;
        }

        .btn-return:hover, .btn-edit:hover,
        .btn-return:focus, .btn-edit:focus {
            background-color: #0d1b2a;
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .card-body {
                padding: 1.75rem 1rem;
                font-size: 0.9rem; /* Unificado: Ahora hereda o es 0.9rem */
            }

            .btn-return, .btn-edit {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
        /* Estilos para la tabla de historial de precios */
        .price-history-card .card-header {
            background-color: #1b263b; /* Un color ligeramente diferente para la segunda tarjeta */
            border-bottom: 4px solid #cda34f;
        }

        .price-history-card .card-header .header-title {
            color: #ffffff;
            font-size: 1.1rem; /* Mantiene el mismo tamaño que el título de la primera tarjeta, ajustado */
        }

        .table-price-history {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.9rem; /* Unificado: Ahora hereda o es 0.9rem */
        }

        .table-price-history th,
        .table-price-history td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            font-size: 0.9rem; /* Unificado: Ahora hereda o es 0.9rem */
        }

        .table-price-history th {
            background-color: #f2f2f2;
            font-weight: 600;
            color: #333;
        }

        .table-price-history tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-price-history tbody tr:hover {
            background-color: #e6f0ff;
        }

        .price-change-up {
            color: #28a745; /* Verde para subida de precio */
            font-weight: bold;
        }

        .price-change-down {
            color: #dc3545; /* Rojo para bajada de precio */
            font-weight: bold;
        }

        .price-change-neutral {
            color: #6c757d; /* Gris para sin cambio */
            font-weight: normal;
        }
    </style>

    <div class="container py-1">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title"><i class="bi bi-boxes me-2"></i>Detalles del producto.</div>
                        @isset($producto)
                            <small>Creado {{ $producto->created_at->diffForHumans() }}.</small>
                        @endisset
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><i class="bi bi-upc-scan me-2"></i><strong>Código:</strong> {{ $producto->codigo }}.</p>
                                <p><i class="bi bi-qr-code me-2"></i><strong>Serie:</strong> {{ $producto->serie }}.</p>
                                <p><i class="bi bi-card-text me-2"></i><strong>Nombre:</strong> {{ $producto->nombre }}.</p>
                                <p><i class="bi bi-tag me-2"></i><strong>Marca:</strong> {{ $producto->marca }}.</p>
                                <p><i class="bi bi-cpu me-2"></i><strong>Modelo:</strong> {{ $producto->modelo }}.</p>
                                <p><i class="bi bi-briefcase-fill me-2"></i><strong>Categoría:</strong> {{ $producto->categoria }}.</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-box-fill me-2"></i><strong>Cantidad actual:</strong> {{ floor($producto->cantidad) }}.</p> {{-- Cantidad movida aquí --}}
                                <p><i class="bi bi-percent me-2"></i><strong>Impuesto:</strong> {{ $producto->impuesto->nombre ?? 'N/A' }} ({{ $producto->impuesto->porcentaje ?? '0' }}%).</p>
                                <p><i class="bi bi-currency-dollar me-2"></i><strong>Precio de compra actual:</strong> Lps. {{ number_format($producto->precio_compra, 2) }}.</p>
                                <p><i class="bi bi-cash-stack me-2"></i><strong>Precio de venta actual:</strong> Lps. {{ number_format($producto->precio_venta, 2) }}.</p>
                                <p><i class="bi bi-pencil-square me-2"></i><strong>Descripción:</strong> <br>{{ $producto->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <small>Última actualización: {{ $producto->updated_at->diffForHumans() }}.</small>
                    </div>
                </div>

                {{-- Nueva tarjeta para el historial de precios de compra --}}
                <div class="card price-history-card">
                    <div class="card-header">
                        <div class="header-title"><i class="bi bi-graph-up-arrow me-2"></i>Variación de precios de compra.</div>
                    </div>
                    <div class="card-body">
                        @if ($producto->precioCompras->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-price-history">
                                    <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Precio</th>
                                        <th>Cambio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($producto->precioCompras as $index => $precioHistorial)
                                        @php
                                            // Obtener el precio del elemento cronológicamente anterior (que es el siguiente en la colección ordenada DESC)
                                            $olderPrice = $producto->precioCompras->get($index + 1)->precio_compra ?? null;
                                        @endphp
                                        <tr>
                                            <td>{{ $precioHistorial->created_at->format('d/m/Y H:i') }}</td>
                                            <td>Lps. {{ number_format($precioHistorial->precio_compra, 2) }}</td>
                                            <td>
                                                @if ($olderPrice !== null)
                                                    @if ($precioHistorial->precio_compra > $olderPrice)
                                                        <span class="price-change-up"><i class="bi bi-arrow-up-circle-fill me-1"></i> Subió (Lps. {{ number_format($precioHistorial->precio_compra - $olderPrice, 2) }})</span>
                                                    @elseif ($precioHistorial->precio_compra < $olderPrice)
                                                        <span class="price-change-down"><i class="bi bi-arrow-down-circle-fill me-1"></i> Bajó (Lps. {{ number_format($olderPrice - $precioHistorial->precio_compra, 2) }})</span>
                                                    @else
                                                        <span class="price-change-neutral"><i class="bi bi-dash-circle-fill me-1"></i> Sin cambio</span>
                                                    @endif
                                                @else
                                                    <span class="price-change-neutral">Precio inicial</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-muted">No hay historial de precios de compra para este producto.</p>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                    <a href="{{ route('productos.index') }}" class="btn btn-return">
                        <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
