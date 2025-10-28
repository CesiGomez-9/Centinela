@extends('plantilla')
@section('titulo', 'Detalles de la Asistencia')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('https://www.transparenttextures.com/patterns/beige-paper.png') repeat fixed #f8f4ec;
            font-size: 15px;
        }

        .card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: #ffffff;
            max-width: 750px;
            margin: 0 auto 2rem auto;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.01);
        }

        .card-header {
            background-color: #0d1b2a;
            padding: 1.2rem 1.5rem;
            border-bottom: 3px solid #cda34f;
        }

        .card-header h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
        }

        .card-header small {
            color: #f0e6d2;
            font-size: 0.8rem;
        }

        .card-body {
            padding: 1.6rem 1.5rem;
            font-size: 0.95rem;
        }

        .card-body p {
            margin-bottom: 1rem;
            border-left: 3px solid #cda34f;
            padding-left: 0.6rem;
        }

        .card-body i {
            color: #1b263b;
        }

        .card-body strong {
            color: #0d1b2a;
            font-weight: 600;
        }

        .card-footer {
            background-color: #1b263b;
            padding: 0.7rem 1.2rem;
            border-top: 1px solid #cda34f;
            font-size: 0.85rem;
        }

        .card-footer small {
            color: #f5f5f5;
        }

        .btn-return {
            background-color: #cda34f;
            color: #ffffff;
            border: none;
            padding: 0.55rem 1.2rem;
            border-radius: 0.4rem;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            font-size: 0.95rem;
            margin-top: 1.2rem;
        }

        .btn-return:hover,
        .btn-return:focus {
            background-color: #0d1b2a;
            color: #ffffff;
        }

        /* Historial styles */
        .historial-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin: 0 auto 2rem auto;
            max-width: 950px; /* un poco menos ancho que la tarjeta principal */
        }

        .historial-card h6 {
            font-weight: 600;
            border-bottom: 2px solid #cda34f;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
            color: #0d1b2a;
        }

        .historial-table th, .historial-table td {
            vertical-align: middle;
            text-align: center;
        }

        .historial-table th {
            background-color: #0d1b2a;
            color: #fff;
        }

        .historial-table tbody tr:hover {
            background-color: #f7f1e3;
        }

        @media (max-width: 767.98px) {
            .card, .historial-card {
                max-width: 90%;
            }

            .card-body {
                padding: 1.2rem;
                font-size: 0.9rem;
            }

            .btn-return {
                width: 100%;
            }
        }
    </style>

    <div class="container py-5">
        {{-- 1️⃣ Tarjeta principal: Detalles de asistencia --}}
        <div class="card mb-4">
            <div class="card-header position-relative">
                <h5><i class="bi bi-clipboard-check me-2"></i>Detalles de la asistencia</h5>
                <small class="position-absolute top-50 end-0 translate-middle-y me-3">
                    Creado {{ $asistencia->created_at->diffForHumans() }}
                </small>
            </div>

            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <p><i class="bi bi-person-fill me-2"></i><strong>Empleado:</strong>
                            {{ $asistencia->nombre }} {{ $asistencia->apellido }}
                        </p>
                        <p><i class="bi bi-credit-card-2-front me-2"></i><strong>Identidad:</strong>
                            {{ $asistencia->identidad }}
                        </p>
                        <p><i class="bi bi-calendar-event me-2"></i><strong>Fecha:</strong>
                            {{ $asistencia->created_at ? $asistencia->created_at->format('d/m/Y') : '-' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><i class="bi bi-clock-history me-2"></i><strong>Hora de entrada:</strong>
                            {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('h:i A') : 'No registrada' }}
                        </p>
                        <p><i class="bi bi-clock me-2"></i><strong>Hora de salida:</strong>
                            {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('h:i A') : 'No registrada' }}
                        </p>
                        <p><i class="bi bi-calendar-week me-2"></i><strong>Tipo de turno:</strong>
                            {{ $asistencia->turno ? $asistencia->turno->tipo_turno : 'Sin turno asignado' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <small>Última actualización: {{ $asistencia->updated_at->diffForHumans() }}</small>
            </div>
        </div>

        {{-- 2️⃣ Historial en card blanco, un poco menos ancho --}}
        <div class="historial-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h6><i class="bi bi-list-check me-2"></i>Historial de entradas y salidas</h6>

                {{-- Filtro de fechas --}}
                <form method="GET" class="d-flex gap-2 align-items-start flex-wrap">
                    <div class="d-flex flex-column gap-1">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Desde</span>
                            <input type="date" name="fecha_inicio" class="form-control"
                                   value="{{ request('fecha_inicio') ?? \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   max="{{ \Carbon\Carbon::now()->addMonths(2)->format('Y-m-d') }}">
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Hasta</span>
                            <input type="date" name="fecha_fin" class="form-control"
                                   value="{{ request('fecha_fin') ?? \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   min="{{ \Carbon\Carbon::now()->subMonths(2)->format('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-1">
                        <button type="submit" class="btn btn-sm btn-primary px-2 py-1">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('asistencias.show', $asistencia->id) }}" class="btn btn-sm btn-secondary px-2 py-1">
                            <i class="bi bi-x-circle me-1"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabla de historial --}}
            <div class="table-responsive">
                @if($historial->isNotEmpty())
                    <table class="table table-bordered historial-table text-center">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Hora de Entrada</th>
                            <th>Hora de Salida</th>
                            <th>Tipo de Turno</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($historial as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>{{ $item->hora_entrada ? \Carbon\Carbon::parse($item->hora_entrada)->format('h:i A') : 'No registrada' }}</td>
                                <td>{{ $item->hora_salida ? \Carbon\Carbon::parse($item->hora_salida)->format('h:i A') : 'No registrada' }}</td>
                                <td>{{ $item->turno?->tipo_turno ?? 'Sin turno' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-muted">No hay registros de entradas y salidas en el rango seleccionado.</p>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('asistencias.index') }}" class="btn btn-return">
                <i class="bi bi-arrow-left me-2"></i>Volver a la lista
            </a>
        </div>
    </div>
@endsection
