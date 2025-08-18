@extends('plantilla')
@section('content')

    <!-- Hero Section -->
    <div class="hero-section text-white d-flex align-items-center justify-content-center" style="background-image: url('{{ asset('fondo2.jpg') }}'); background-size: cover; background-position: center; height: 450px; position: relative; text-align: center;">
        <div style="position: relative; z-index: 2; background: linear-gradient(135deg, rgba(10,31,68,0.7), rgba(10,31,68,0.4)); padding: 2.5rem 3rem; border-radius: 15px; font-family: 'Poppins', sans-serif;">
            <h1 style="font-size: 3rem; font-weight: 800;">Protección Total</h1>
            <p style="font-size: 1.2rem;">Vigilancia profesional las 24 horas del día</p>
        </div>
    </div>

    <hr class="my-5 text-light">

    <!-- Servicios -->
    <div class="container my-5">
        <h2 class="text-center mb-5 fw-bold" style="font-family: 'Montserrat', sans-serif;">Nuestros Servicios</h2>

        <div class="row g-4 justify-content-center">
            <!-- Servicio 1 -->
            <div class="col-md-4">
                <div class="card service-card h-100 shadow-sm border-0">
                    <img src="{{ asset('vigilanciaresi.jpg') }}" class="card-img-top" alt="Vigilancia Residencial">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mt-3">Vigilancia Residencial</h5>
                        <p class="card-text text-muted">Protección completa de tu hogar las 24 horas del día.</p>
                    </div>
                </div>
            </div>
            <!-- Servicio 2 -->
            <div class="col-md-4">
                <div class="card service-card h-100 shadow-sm border-0">
                    <img src="{{ asset('monitoreo.jpeg') }}" class="card-img-top" alt="Monitoreo Remoto de Cámaras">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mt-3">Monitoreo Remoto de Cámaras</h5>
                        <p class="card-text text-muted">Supervisión continua desde cualquier lugar, en tiempo real.</p>
                    </div>
                </div>
            </div>
            <!-- Servicio 3 -->
            <div class="col-md-4">
                <div class="card service-card h-100 shadow-sm border-0">
                    <img src="{{ asset('instalacion.jpg') }}" class="card-img-top" alt="Instalación de Cámaras de Seguridad">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mt-3">Instalación de Cámaras de Seguridad</h5>
                        <p class="card-text text-muted">Instalamos cámaras de alta calidad para máxima protección.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center mt-3">
            <!-- Servicio 4 -->
            <div class="col-md-4">
                <div class="card service-card h-100 shadow-sm border-0">
                    <img src="{{ asset('instalacionA.jpg') }}" class="card-img-top" alt="Instalación de Sistemas de Alarma">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mt-3">Instalación de Sistemas de Alarma</h5>
                        <p class="card-text text-muted">Alarmas confiables para proteger tu hogar o negocio.</p>
                    </div>
                </div>
            </div>
            <!-- Servicio 5 -->
            <div class="col-md-4">
                <div class="card service-card h-100 shadow-sm border-0">
                    <img src="{{ asset('mantenimiento.jpg') }}" class="card-img-top" alt="Mantenimiento de Sistemas de Seguridad">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mt-3">Mantenimiento de Sistemas de Seguridad</h5>
                        <p class="card-text text-muted">Revisiones periódicas para asegurar que todo funcione correctamente.</p>
                    </div>
                </div>
            </div>
            <!-- Servicio 6 -->
            <div class="col-md-4">
                <div class="card service-card h-100 shadow-sm border-0">
                    <img src="{{ asset('cercas.jpg') }}" class="card-img-top" alt="Instalación de Cercas Eléctricas">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mt-3">Instalación de Cercas Eléctricas</h5>
                        <p class="card-text text-muted">Máxima protección perimetral para tu propiedad.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Beneficios -->
        <div class="row text-center mt-5">
            <div class="col-md-4 mb-4">
                <i class="bi bi-shield-lock-fill display-4 text-gold-dark mb-3"></i>
                <h3 class="fw-bold text-gold-dark">Vigilancia 24/7</h3>
                <p class="text-black">Personal altamente capacitado para mantener segura tu empresa o residencia.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-camera-video-fill display-4 text-gold-dark mb-3"></i>
                <h3 class="fw-bold text-gold-dark">Tecnología Avanzada</h3>
                <p class="text-black">Sistemas de cámaras, alarmas y monitoreo inteligente.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-tools display-4 text-gold-dark mb-3"></i>
                <h3 class="fw-bold text-gold-dark">Soporte Técnico</h3>
                <p class="text-black">Nuestro equipo actúa con rapidez y eficacia ante cualquier incidente.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 text-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0 text-md-start">
                    <h3 class="mb-2 text-gold-dark">Grupo Centinela</h3>
                    <p class="mb-0"><strong>Dirección:</strong> Barrio Oriental, cuatro cuadras al sur del parque central.</p>
                    <p class="mb-1">Danlí, El Paraíso, Honduras.</p>
                    <p class="mb-1"><strong>Email:</strong> grupocentinela.hn@gmail.com</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1"><strong>Teléfono fijo:</strong> +504 2763-3585</p>
                    <p class="mb-1"><strong>Celular:</strong> +504 9322-5352</p>
                </div>
            </div>
            <hr class="my-3">
            <p class="mb-0">© 2025 Grupo Centinela. Todos los derechos reservados.</p>
        </div>
    </footer>

    <style>

        body {
            background-color: #F5F5F5;
        }
        /* Tarjetas */
        .service-card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .service-card img {
            height: 220px;
            object-fit: cover;
        }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
        }

        /* Botón servicios */
        a.btn-service {
            transition: all 0.3s ease;
        }
        a.btn-service:hover {
            background-color: #DAA520;
            color: #0A1F44;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Tipografía y colores */
        .text-gold-dark {
            color: #DAA520;
        }
        .card-text {
            font-size: 0.95rem;
        }


    </style>

@endsection
