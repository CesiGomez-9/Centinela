@extends('layouts.plantilla')

@section('titulo', 'Detalles del Producto')

@section('content')
    {{-- Información del inventarios --}}
    <h1 class="text-center mb-4" style="color: #09457f;">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <i class="bi bi-boxes me-2"></i>Detalles del Producto {{ $inventario->nombre }}
    </h1>


    <ul>
        <li>Código: {{ $inventario->codigo }}</li>
        <li>Nombre del producto: {{ $inventario->nombre }}</li>
        <li>Descripción: {{ $inventario->descripcion }}</li>
        <li>Cantidad: {{ $inventario->cantidad }}</li>
        <li>Precio unitario: Lps.{{ $inventario->precio_unitario }}</li>
        <li>Fecha de creación: {{ $inventario->created_at->diffForHumans() }}</li>
        <li>Fecha de actualización: {{ $inventario->updated_at->diffForHumans() }}</li>
    </ul>

    <hr>

    <a href="{{ route('inventarios.index') }}" class="btn btn-outline-primary btn-md">
        <i class="bi bi-arrow-left"></i> Volver a lista de inventarios
    </a>
@endsection

