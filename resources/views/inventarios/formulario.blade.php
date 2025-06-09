@extends('layouts.plantilla')
@section('titulo','Registrar nuevo producto al inventario')
@section('content')

    <h1 class="fs-3 mb-4 text-center">
        @isset($inventario)
            Editar
        @else
            Registrar nuevo producto
        @endisset
            en el inventario
    </h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center align-items-center">

        <!-- Imagen izquierda -->
        <div class="col-md-3 d-flex justify-content-end align-items-start mb-5">
            <img src="{{ asset('centinela.jpg') }}" alt="Grupo Centinela"
                 class="rounded shadow align-self-center"
                 style="height: 300px; width: auto; object-fit: contain;">
        </div>


        <div class="col-md-6">
            <form method="post" action="{{ isset($inventario) ? route('inventarios.update', $inventario->id) : route('inventarios.store') }}">
                @isset($inventario)
                    @method('put')
                @endisset
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control w-100" id="codigo" name="codigo" placeholder="Código" value="{{ old('codigo', $inventario->codigo ?? '') }}">
                    <label for="codigo">Código del Producto</label>
                </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control w-100" id="nombre" name="nombre" placeholder="Nombre" value="{{ old('nombre', $inventario->nombre ?? '') }}">
                        <label for="nombre">Nombre del producto</label>
                    </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control w-100" id="cantidad" name="cantidad" placeholder="Cantidad" value="{{ old('cantidad', $inventario->cantidad ?? '') }}">
                    <label for="cantidad">Cantidad</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" step="0.01" class="form-control w-100" id="precio_unitario" name="precio_unitario" placeholder="Precio" value="{{ old('precio_unitario', $inventario->precio_unitario ?? '') }}">
                    <label for="precio_unitario">Precio Unitario</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control w-100" placeholder="Descripción" name="descripcion" id="descripcion" style="height: 100px">{{ old('descripcion', $inventario->descripcion ?? '') }}</textarea>
                    <label for="descripcion">Descripción</label>
                </div>

                    <div class="text-center mt-4">
                        <input type="submit" value="Guardar" class="btn btn-primary me-2">
                        <a href="{{ route('inventarios.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
            </form>
        </div>

        <!-- Imagen derecha -->
        <div class="col-md-3 d-flex justify-content-start  align-items-start mb-5">
            <img src="{{ asset('invent.jpg') }}" alt="Inventario"
                 class="rounded shadow align-self-center"
                 style="height: 300px; width: auto; object-fit: contain;">
        </div>

    </div>
@endsection

