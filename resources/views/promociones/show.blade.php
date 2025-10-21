@extends('plantilla')
@section('titulo', 'Detalles de la promoción')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

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
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            background: #ffffff;
            max-width: 900px;
            margin: auto;
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

        .nombre-promocion {
            font-size: 2rem;
            font-weight: 700;
            color: #09457f;
            text-align: center;
            margin-bottom: 2rem;
        }

        .imagen-rellena-container {
            position: relative;
            width: 100%;
            max-height: 450px;
            margin-bottom: 2rem;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .imagen-rellena-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .imagen-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.5);
            padding: 1rem 2rem;
            border-radius: 1rem;
            color: #fff;
            text-align: center;
            max-width: 70%;
        }

        .detalle-campo p {
            margin-bottom: 1rem;
            border-left: 4px solid #cda34f;
            padding-left: 0.75rem;
        }

        .card-footer {
            background-color: #1b263b;
            padding: 0.9rem 1.5rem;
            border-top: 1px solid #cda34f;
            font-size: 0.9rem;
            text-align: right;
            color: #f5f5f5;
        }

        @media (max-width: 767.98px) {
            .card-body {
                padding: 1.75rem 1rem;
                font-size: 0.95rem;
            }
        }
        body {
            background-color: #f8f4ec;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            margin: 0;
            padding: 0;
        }

        .btn-return, .btn-edit {
            background-color: #cda34f;
            color: #ffffff;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
            font-size: 0.95rem;
            margin: 0 0.5rem;
        }

        .btn-return:hover, .btn-edit:hover,
        .btn-return:focus, .btn-edit:focus {
            background-color: #0d1b2a;
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .btn-return, .btn-edit {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>

    <div class="container py-4">
        <div class="card">
            <div class="card-header position-relative">
                <h5 class="mb-0"><i class="bi bi-badge-ad-fill me-2"></i>Detalles de la promoción</h5>
                <small class="position-absolute top-50 end-0 translate-middle-y me-3">Creado {{ $promocion->created_at->diffForHumans() }}</small>
            </div>
            <div class="card-body">
                <!-- Nombre grande arriba -->
                <div class="nombre-promocion">{{ $promocion->nombre }}</div>

                <!-- Imagen rellena con overlay -->
                <div class="imagen-rellena-container">
                    <img src="{{ $promocion->imagen ? asset('storage/'.$promocion->imagen) : asset('imagenes/plantilla_promocion.jpg') }}" alt="Promoción">
                    <div class="imagen-overlay">
                        <h3 class="fw-bold mb-2">{{ $promocion->nombre }}</h3>
                        <p class="mb-1">{{ $promocion->descripcion }}</p>
                        <p class="mb-1">{{ $promocion->restriccion }}</p>
                        <p class="small mb-0">Válida desde: {{ \Carbon\Carbon::parse($promocion->fecha_inicio)->format('d/m/Y') }} hasta {{ \Carbon\Carbon::parse($promocion->fecha_fin)->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Campos de detalle debajo -->
                <div class="detalle-campo row g-3">
                    <div class="col-md-6">
                        <p><strong>Nombre de la promoción:</strong> {{ $promocion->nombre }}</p>
                        <p><strong>Descripción:</strong> {{ $promocion->descripcion }}</p>
                        <p><strong>Restricción:</strong> {{ $promocion->restriccion }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Fecha inicio:</strong> {{ \Carbon\Carbon::parse($promocion->fecha_inicio)->format('d/m/Y') }}</p>
                        <p><strong>Fecha fin:</strong> {{ \Carbon\Carbon::parse($promocion->fecha_fin)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                Última actualización: {{ $promocion->updated_at->diffForHumans() }}
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center gap-3 mt-4 flex-wrap">
            <a href="{{ route('promociones.index') }}" class="btn btn-return">
                <i class="bi bi-arrow-left me-2"></i>Volver a la lista
            </a>
            <a href="{{ route('promociones.edit', $promocion->id) }}" class="btn btn-edit">
                <i class="bi bi-pencil-square me-2"></i>Editar promoción
            </a>
        </div>

    </div>
@endsection
