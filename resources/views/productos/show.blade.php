@extends('layouts.plantilla')

@section('titulo', 'Detalles del producto')

@section('content')
    {{-- Información del productos --}}
    <h1 class="text-center mb-4" style="color: #09457f;">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <i class="bi bi-boxes me-2"></i>Detalles del producto {{ $producto->nombre }}
    </h1>


    <ul>
        <li>Serie: {{ $producto->serie }}</li>
        <li>Código: {{ $producto->codigo }}</li>
        <li>Nombre del producto: {{ $producto->nombre }}</li>
        <li>Marca: {{ $producto->marca }}</li>
        <li>Modelo: {{ $producto->modelo }}</li>
        <li>Descripción: {{ $producto->descripcion }}</li>
        <li>Material de fabricación: {{ $producto->material }}</li>
        <li>Fecha de creación: {{ $producto->created_at->diffForHumans() }}</li>
        <li>Fecha de actualización: {{ $producto->updated_at->diffForHumans() }}</li>
    </ul>

    <hr>

    <a href="{{ route('productos.index') }}" class="btn btn-outline-primary btn-md">
        <i class="bi bi-arrow-left"></i> Volver a lista de productos
    </a>
@endsection

