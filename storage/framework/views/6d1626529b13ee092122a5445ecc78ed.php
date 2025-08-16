<?php $__env->startSection('content'); ?>
    <style>
        /* Fondo del calendario */
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
        }

        .fc-toolbar.fc-header-toolbar {
            margin-bottom: 1.5rem;
        }
    </style>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Calendario de Instalaciones</h3>
        <div id="calendar" class="mx-auto" style="max-width: 900px;"></div>


    </div>

    <!-- Modal para mostrar detalles -->
    <div class="modal fade" id="detalleEventoModal" tabindex="-1" aria-labelledby="detalleEventoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleEventoLabel">Detalle de Instalación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Cliente - Servicio:</strong> <span id="modal-title"></span></p>
                    <p><strong>Descripción:</strong> <span id="modal-descripcion"></span></p>
                    <p><strong>Dirección:</strong> <span id="modal-direccion"></span></p>
                    <p><strong>Costo:</strong> L. <span id="modal-costo"></span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- FullCalendar & Bootstrap JS/CDN -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/es.global.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        eventClick: function(info) {
            info.jsEvent.preventDefault();

            // Obtener datos extendidos del evento
            const props = info.event.extendedProps;

            // Setear datos en el modal
            document.getElementById('modal-title').textContent = info.event.title;
            document.getElementById('modal-descripcion').textContent = props.descripcion || 'N/A';
            document.getElementById('modal-direccion').textContent = props.direccion || 'N/A';
            document.getElementById('modal-costo').textContent = props.costo ? Number(props.costo).toFixed(2) : '0.00';

            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('detalleEventoModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es', // Español
                height: 'auto', // Automático
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: '/instalaciones/eventos', // URL de tus eventos
                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    // Cargar contenido del modal aquí
                    const instalacionId = info.event.id;
                    fetch(/instalaciones/${instalacionId})
                .then(response => response.text())
                        .then(html => {
                            document.getElementById('modal-body-content').innerHTML = html;
                            new bootstrap.Modal(document.getElementById('instalacionModal')).show();
                        });
                }
            });

            calendar.render();
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/Instalaciones/index.blade.php ENDPATH**/ ?>