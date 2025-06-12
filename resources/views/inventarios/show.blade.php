@extends('layouts.plantilla')

@section('titulo', 'Detalles del Producto')

@section('content')
    {{-- Información del inventarios --}}
    <h1>Detalles del Producto {{ $inventario->nombre }}</h1>

    <ul>
        <li>Codigo: {{ $inventario->id }}</li>
        <li>Nombre: {{ $inventario->nombre }}</li>
        <li>Descripción: {{ $inventario->descripcion }}</li>
        <li>Cantidad: {{ $inventario->cantidad }}</li>
        <li>Precio: {{ $inventario->ubicacion }}</li>
        <li>Fecha de Creación: {{ $inventario->created_at->diffForHumans() }}</li>
        <li>Fecha de Actualización: {{ $inventario->updated_at->diffForHumans() }}</li>
    </ul>

    <hr>

    <a href="{{ route('inventarios.index') }}" class="btn btn-primary">Volver a Lista de Inventario</a>
@endsection

