<!-- resources/views/instalaciones/partials/detalle.blade.php -->
<div class="row g-3">
    <div class="col-md-6">
        <p><i class="bi bi-person-badge me-2"></i><strong>Cliente:</strong> {{ $instalacion->cliente->nombre }}</p>
        <p><i class="bi bi-tools me-2"></i><strong>Servicio:</strong> {{ $instalacion->servicio->nombre }}</p>
        <p><i class="bi bi-calendar-event me-2"></i><strong>Fecha:</strong> {{ $instalacion->fecha_instalacion }}</p>
        <p><i class="bi bi-geo-alt me-2"></i><strong>Dirección:</strong> {{ $instalacion->direccion }}</p>
    </div>
    <div class="col-md-6">
        <p><i class="bi bi-cash-coin me-2"></i><strong>Costo:</strong> L. {{ $instalacion->costo_instalacion }}</p>
        <p><i class="bi bi-people me-2"></i><strong>Técnicos:</strong>
        <ul>
            @foreach($instalacion->empleados as $empleado)
                <li>{{ $empleado->nombre }}</li>
            @endforeach
        </ul>
        </p>
        <p><i class="bi bi-receipt me-2"></i><strong>Factura:</strong> {{ $instalacion->factura_id ?? 'No aplica' }}</p>
    </div>
    <div class="col-12">
        <p><i class="bi bi-file-text me-2"></i><strong>Descripción:</strong> {{ $instalacion->descripcion }}</p>
    </div>
</div>
