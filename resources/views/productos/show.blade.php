@extends('layouts.plantilla')

@section('titulo', 'Detalles del producto')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white text-center position-relative">
                        <h5 class="mb-0">
                            <i class="bi bi-boxes me-2"></i> Detalles del producto
                        </h5>
                        <small class="position-absolute top-50 end-0 translate-middle-y me-3 text-white">
                            Creado {{ $producto->created_at->diffForHumans() }}
                        </small>
                    </div>


                    <div class="card-body">
                        <div class="row g-5 fs-5">
                            <div class="col-md-6">
                                <p><i class="bi bi-upc-scan me-2 text-dark"></i><strong>Código:</strong> {{ $producto->codigo }}</p>
                                <p><i class="bi bi-qr-code me-2 text-dark"></i><strong>Serie:</strong> {{ $producto->serie }}</p>
                                <p><i class="bi bi-card-text me-2 text-dark"></i><strong>Nombre:</strong> {{ $producto->nombre }}</p>
                                <p><i class="bi bi-tag me-2 text-dark"></i><strong>Marca:</strong> {{ $producto->marca }}</p>
                            </div>

                            <div class="col-md-6">
                                <p><i class="bi bi-cpu me-2 text-dark"></i><strong>Modelo:</strong> {{ $producto->modelo }}</p>
                                <p><i class="bi bi-briefcase-fill me-2 text-dark"></i><strong>Categoría:</strong> {{ $producto->categoria }}</p>
                                <p><i class="bi bi-layers me-2 text-dark"></i><strong>Material:</strong> {{ $producto->material }}</p>
                                <p><i class="bi bi-pencil-square me-2 text-dark"></i><strong>Descripción:</strong><br>{{ $producto->descripcion }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end bg-light">
                        <small class="text-muted">Última actualización: {{ $producto->updated_at->diffForHumans() }}</small>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-dark">
                        <i class="bi bi-arrow-left me-2"></i> Volver a la lista de productos
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
