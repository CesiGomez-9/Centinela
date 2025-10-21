@extends('plantilla')
@section('content')

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show mt-3 mx-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <style>
        body {
            background-color: #f8f4ec;
            font-family: 'Inter', sans-serif;
        }

        .card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: #ffffff;
            max-width: 900px;
            margin: 10px auto;
        }

        .card-header {
            background-color: #0a1f3a;
            padding: 0.8rem 1.2rem;
            border-bottom: 1px solid #cda34f;
            text-align: center;
            position: relative;
        }

        .card-header h5 {
            color: #ffffff;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .promo-image {
            width: 100%;
            max-height: 320px;
            object-fit: cover;
            border-bottom: 4px solid #cda34f;
        }

        .card-body {
            padding: 1rem 1.5rem;
            font-size: 0.95rem;
        }

        .card-body p {
            margin-bottom: 0.6rem;
            border-left: 4px solid #cda34f;
            padding-left: 0.6rem;
        }

        .card-footer {
            background-color: #0a1f3a;
            color: #f5f5f5;
            border-top: 1px solid #cda34f;
            padding: 0.6rem 1rem;
            text-align: right;
            font-size: 0.85rem;
        }

        .btn-return, .btn-edit {
            background-color: #cda34f;
            color: #ffffff;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            margin: 0 0.5rem;
        }

        .btn-return:hover, .btn-edit:hover {
            background-color: #0d1b2a;
        }
    </style>

    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-megaphone-fill me-2"></i>Detalles de la Promoción</h5>
                <small class="text-light position-absolute top-50 end-0 translate-middle-y me-3">
                    Creado: {{ $promocion->created_at ? $promocion->created_at->diffForHumans() : 'Fecha no disponible' }}
                </small>

            </div>

            @if($promocion->imagen)
                <img src="{{ asset('storage/' . $promocion->imagen) }}" alt="Imagen de la promoción" class="promo-image">
            @else
                <div style="background-color:#f4f4f4; color:#777; text-align:center; padding:2rem; border-bottom:3px solid #cda34f;">
                    <i class="bi bi-image me-2"></i>No hay imagen disponible
                </div>
            @endif

            <div class="card-body">
                <p><i class="bi bi-tag-fill me-2"></i><strong>Nombre:</strong> {{ $promocion->nombre }}</p>
                <p><i class="bi bi-calendar-event-fill me-2"></i><strong>Fecha de inicio:</strong> {{ $promocion->fecha_inicio }}</p>
                <p><i class="bi bi-calendar2-event-fill me-2"></i><strong>Fecha de fin:</strong> {{ $promocion->fecha_fin }}</p>
                <p><i class="bi bi-card-text me-2"></i><strong>Descripción:</strong><br> {{ $promocion->descripcion ?? 'Sin descripción' }}</p>
            </div>

            <div class="card-footer">
                <small>Última actualización: {{ $promocion->updated_at ? $promocion->updated_at->diffForHumans() : 'Fecha no disponible' }}</small>
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
