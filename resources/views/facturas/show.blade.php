@extends('plantilla')
@section('titulo', 'Detalles de la Factura')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Aquí puedes dejar los estilos que tenías */
    </style>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="card">
                    <div class="card-header position-relative">
                        <h5 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Detalles de la Factura</h5>
                        <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                            Creada {{ $factura->created_at->diffForHumans() }}
                        </small>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><i class="bi bi-file-earmark-text me-2"></i><strong>Número de Factura:</strong> {{ $factura->numero_factura }}</p>
                                <p><i class="bi bi-calendar me-2"></i><strong>Fecha:</strong> {{ $factura->fecha }}</p>
                                <p><i class="bi bi-truck me-2"></i><strong>Proveedor:</strong> {{ $factura->proveedor }}</p>
                                <p><i class="bi bi-wallet2 me-2"></i><strong>Forma de Pago:</strong> {{ $factura->forma_pago }}</p>
                                <p><i class="bi bi-person-circle me-2"></i><strong>Responsable:</strong>
                                    @if ($factura->empleado)
                                        {{ $factura->empleado->nombre }} {{ $factura->empleado->apellido }} (ID: {{ $factura->empleado->id }})
                                    @else
                                        No asignado
                                    @endif
                                <p><strong>Responsable:</strong>
                                    @if ($factura->empleado)
                                        {{ $factura->empleado->nombre }} {{ $factura->empleado->apellido }}
                                    @else
                                        No asignado
                                    @endif
                                </p>
                                </p>
                            </div>

                            <div class="col-md-6">
                                <h6><i class="bi bi-box-seam me-2"></i>Productos:</h6>
                                <ul class="list-group">
                                    @foreach ($factura->producto)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $producto->pivot->nombre }} (x{{ $producto->pivot->cantidad }})
                                            <span class="badge bg-primary rounded-pill">L. {{ $producto->pivot->subtotal }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <hr>
                                <p><i class="bi bi-cash-coin me-2"></i><strong>Subtotal:</strong> L. {{ $factura->subtotal }}</p>
                                <p><i class="bi bi-percent me-2"></i><strong>Impuestos:</strong> L. {{ $factura->impuestos }}</p>
                                <p><i class="bi bi-calculator me-2"></i><strong>Total:</strong> L. {{ $factura->totalF }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <small>Última actualización: {{ $factura->updated_at->diffForHumans() }}</small>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
                    <a href="{{ route('facturas.index') }}" class="btn btn-return">
                        <i class="bi bi-arrow-left me-2"></i>Volver a la lista
                    </a>
                    <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-edit">
                        <i class="bi bi-pencil-square me-2"></i>Editar Factura
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
