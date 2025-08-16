@extends('plantilla')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
            padding: 2rem 0; /* para que no quede pegado arriba y abajo */
            font-family: 'Inter', sans-serif;
        }

        /* Contenedor que abarca título, buscador, botón y calendario */
        .header-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff; /* fondo blanco */
            border-radius: 1.25rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem 2rem 3rem 2rem; /* arriba, derecha, abajo, izquierda */
        }

        /* Título */
        .header-title {
            text-align: center;
            font-weight: 700;
            font-size: 1.5rem;
            color: #0d1b2a;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .header-title i {
            font-size: 1.8rem;
        }

        /* Contenedor buscador + botón */
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .header-row > div {
            max-width: 400px;
            width: 100%;
        }

        #buscador {
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem 0 0 0.375rem;
            height: 40px;
            border-right: none;
        }

        .input-group-text {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-left: none;
            border-radius: 0 0.375rem 0.375rem 0;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-programar {
            min-width: 170px;
            color: #1b4f72;
            border-color: #1b4f72;
            font-weight: normal;
            transition: background-color 0.3s ease, color 0.3s ease;
            height: 40px;
        }

        .btn-programar:hover,
        .btn-programar:focus {
            background-color: #3a7ab8; /* azul más claro */
            color: white;
            text-decoration: none;
        }


        /* Calendario: eliminamos fondo blanco porque ya lo tiene el contenedor */
        #calendar {
            /* background-color: transparent; */
            border-radius: 0.75rem;
            font-family: inherit;
            /* padding: 0; */
        }

        .fc .fc-toolbar-title {
            color: #0d1b2a;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .fc-button, .fc-button-primary {
            background-color: #cda34f;
            border-color: #cda34f;
            color: #fff;
        }

        .fc-button:hover, .fc-button-primary:hover {
            background-color: #0d1b2a;
            border-color: #0d1b2a;
        }

        .fc-daygrid-day-number {
            color: #0d1b2a;
            font-weight: 600;
        }

        .fc-event {
            background-color: #1b263b;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 6px;
            padding: 2px 4px;
        }

        .fc-toolbar.fc-header-toolbar {
            margin-bottom: 1.5rem;
        }

        @media (max-width: 576px) {
            .header-row {
                flex-direction: column;
                align-items: stretch;
            }
            #buscador, .btn-programar {
                width: 100%;
                height: 40px;
                margin-bottom: 0.5rem;
            }
        }

        /* Modal y demás estilos mantienen igual (omito para brevedad, se agregan igual al final) */

        /* (Puedes agregar los estilos para modal que tenías antes aquí si quieres) */
    </style>

    <div class="header-container">
        <h3 class="header-title">
            <i class="bi bi-calendar3"></i>
            Calendario de Instalaciones
        </h3>

        <div class="header-row">
            <div>
                <div class="input-group">
                    <input
                        type="text"
                        id="buscador"
                        placeholder="Buscar por cliente, servicio o dirección..."
                        autocomplete="off"
                        class="form-control"
                    >
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>

            <a href="{{ route('instalaciones.formulario') }}" class="btn btn-outline-primary btn-programar">
                <i class="bi bi-arrow-left"></i> Programar Instalación
            </a>
        </div>

        <div id="calendar" class="mx-auto" style="max-width: 900px;"></div>
    </div>

    <!-- Modal Detalle Mejorado -->
    <div class="modal fade" id="detalleEventoModal" tabindex="-1" aria-labelledby="detalleEventoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between">
                    <img src="{{ asset('centinela.jpg') }}" alt="Logo" style="height: 40px; width: 40px; object-fit: cover;">
                    <h5 class="modal-title flex-grow-1 text-center" id="detalleEventoLabel" style="margin: 0;">
                        Detalle de Instalación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detalle-item">
                                <i class="bi bi-person-circle icono"></i>
                                <span class="info-label">Cliente:</span>
                                <span class="info-value" id="modal-cliente"></span>
                            </div>
                            <div class="detalle-item">
                                <i class="bi bi-gear icono"></i>
                                <span class="info-label">Servicio:</span>
                                <span class="info-value" id="modal-servicio"></span>
                            </div>
                            <div class="detalle-item">
                                <i class="bi bi-cash-stack icono"></i>
                                <span class="info-label">Costo:</span>
                                <span class="info-value">L. <span id="modal-costo"></span></span>
                            </div>
                            <div class="detalle-item">
                                <i class="bi bi-receipt icono"></i>
                                <span class="info-label">Factura:</span>
                                <span class="info-value" id="modal-factura"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detalle-item">
                                <i class="bi bi-geo-alt icono"></i>
                                <span class="info-label">Dirección:</span>
                                <span class="info-value" id="modal-direccion"></span>
                            </div>
                            <div class="detalle-item">
                                <i class="bi bi-card-text icono"></i>
                                <span class="info-label">Descripción:</span>
                                <span class="info-value" id="modal-descripcion"></span>
                            </div>
                            <div class="detalle-item">
                                <i class="bi bi-people icono"></i>
                                <span class="info-label">Técnicos:</span>
                                <span class="info-value" id="modal-tecnicos"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                height: 'auto',
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    list: 'Lista'
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    const q = document.getElementById('buscador').value.trim();

                    const params = new URLSearchParams({
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr,
                    });

                    if(q) {
                        params.append('q', q);
                    }

                    fetch('/instalaciones/eventos?' + params.toString())
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(() => failureCallback());
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    const props = info.event.extendedProps;

                    document.getElementById('modal-cliente').textContent = props.cliente || 'N/A';
                    document.getElementById('modal-servicio').textContent = props.servicio || 'N/A';
                    document.getElementById('modal-descripcion').textContent = props.descripcion || 'Sin descripción';
                    document.getElementById('modal-direccion').textContent = props.direccion || 'Sin dirección';
                    document.getElementById('modal-costo').textContent = props.costo ? Number(props.costo).toFixed(2) : '0.00';
                    document.getElementById('modal-factura').textContent = props.factura || 'No aplica';
                    document.getElementById('modal-tecnicos').textContent = props.tecnicos && props.tecnicos.length > 0 ? props.tecnicos.join(', ') : 'Sin asignar';

                    let modal = new bootstrap.Modal(document.getElementById('detalleEventoModal'));
                    modal.show();
                }
            });

            calendar.render();

            const buscador = document.getElementById('buscador');
            buscador.addEventListener('input', function () {
                calendar.refetchEvents();
            });
        });
    </script>
@endsection
