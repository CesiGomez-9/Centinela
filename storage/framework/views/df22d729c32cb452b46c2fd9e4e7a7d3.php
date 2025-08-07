<?php $__env->startSection('content'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Fondo y estilo del calendario */
        #calendar {
            background-color: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            padding: 1rem;
            font-family: 'Inter', sans-serif;
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

        /* Modal Header: azul oscuro */
        .modal-header {
            background-color: #0a1f3a !important;
            color: #fff;
            border-bottom: 8px solid #0a1f3a;
        }

        .modal-header img {
            border-radius: 6px;
        }

        .modal-header .modal-title {
            color: #fff; /* Título blanco sobre fondo azul */
            font-weight: bold;
        }

        .btn-close {
            filter: invert(1); /* Botón cerrar en blanco */
        }

        /* Modal Body con borde inferior azul */
        .modal-body {
            border-bottom: 8px solid #0a1f3a;
            padding-bottom: 12px;
        }

        /* Detalle de cada campo */
        .detalle-item {
            display: flex;
            align-items: center;
            padding: 6px 10px;
            margin-bottom: 6px;
            border-left: 4px solid #cda34f; /* Línea dorada a la izquierda */
        }

        .detalle-item .icono {
            font-size: 1.1rem;
            color: #0d1b2a;
            margin-right: 8px;
        }

        .detalle-item .info-label {
            font-weight: bold;
            margin-right: 6px;
            color: #0d1b2a;
            font-size: 0.95rem;
        }

        .detalle-item .info-value {
            color: #1b263b;
            font-size: 0.95rem;
        }

        /* Estilo general del modal */
        .modal-content {
            background: #ffffff;
            border-radius: 10px;
            border: none;
        }

        body {
            background-color: #e6f0ff;
            height: 100vh;
            margin: 0;
        }

        /* Botón azul contorno y relleno al hover */
        .btn-hover-fill {
            transition: background-color 0.3s ease, color 0.3s ease;
            color: #0a8ccf;
            border-color: #0a8ccf;
        }

        .btn-hover-fill:hover,
        .btn-hover-fill:focus {
            background-color: #0a8ccf;
            color: white;
            text-decoration: none;
        }
    </style>

    <div class="container mt-5" style="max-width: 900px; position: relative;">
        <!-- Título centrado absolutamente -->
        <h3 class="position-absolute start-50 translate-middle-x m-0 d-flex align-items-center" style="gap: 0.5rem; top: 0;">
            <i class="bi bi-calendar3" style="font-size: 1.5rem; color: #0d1b2a;"></i>
            Calendario de Instalaciones
        </h3>

        <!-- Botón alineado a la derecha -->
        <div class="d-flex justify-content-end mb-4" style="padding-top: 0.5rem;">
            <a href="<?php echo e(route('instalaciones.formulario')); ?>" class="btn btn-outline-info btn-hover-fill">
                <i class="bi bi-plus-circle"></i> Programar instalación
            </a>
        </div>
    </div>

    <div id="calendar" class="mx-auto" style="max-width: 900px;"></div>

    <!-- Modal Detalle Mejorado -->
    <div class="modal fade" id="detalleEventoModal" tabindex="-1" aria-labelledby="detalleEventoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between">
                    <!-- Logo cuadrado -->
                    <img src="<?php echo e(asset('centinela.jpg')); ?>" alt="Logo" style="height: 40px; width: 40px; object-fit: cover;">
                    <!-- Título -->
                    <h5 class="modal-title flex-grow-1 text-center" id="detalleEventoLabel" style="margin: 0;">
                        Detalle de Instalación
                    </h5>
                    <!-- Botón cerrar -->
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
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
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
                events: '/instalaciones/eventos', // Ruta que devuelve JSON de eventos
                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    const props = info.event.extendedProps;

                    // Insertar datos en el modal
                    document.getElementById('modal-cliente').textContent = props.cliente || 'N/A';
                    document.getElementById('modal-servicio').textContent = props.servicio || 'N/A';
                    document.getElementById('modal-descripcion').textContent = props.descripcion || 'Sin descripción';
                    document.getElementById('modal-direccion').textContent = props.direccion || 'Sin dirección';
                    document.getElementById('modal-costo').textContent = props.costo ? Number(props.costo).toFixed(2) : '0.00';
                    document.getElementById('modal-factura').textContent = props.factura || 'No aplica';
                    document.getElementById('modal-tecnicos').textContent = props.tecnicos && props.tecnicos.length > 0 ? props.tecnicos.join(', ') : 'Sin asignar';

                    const modal = new bootstrap.Modal(document.getElementById('detalleEventoModal'));
                    modal.show();
                }
            });

            calendar.render();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\angel\PhpstormProjects\Centinela\resources\views/instalaciones/index.blade.php ENDPATH**/ ?>