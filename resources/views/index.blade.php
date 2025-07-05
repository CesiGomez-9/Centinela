@extends('plantilla')
@section('content')

    <div class="hero-section text-white d-flex align-items-center justify-content-center" style="
    background-image: url('{{ asset('seguridad/fondo2.jpg') }}');
    background-size: cover;
    background-position: center;
    height: 450px;
    position: relative;
    text-align: center;
">
        <div style="
        background-color: rgba(10, 31, 68, 0.6);
        padding: 2rem;
        border-radius: 10px;
    ">
            <h1 style="font-size: 3rem; font-weight: bold;">Protección Total</h1>
            <p style="font-size: 1.2rem;">Vigilancia profesional las 24 horas del día</p>
        </div>
    </div>


    <div class="text-center">
        <h1 class="display-4 text-gold-dark fw-bold">Bienvenido a Grupo Centinela</h1>
        <p class="lead text-light mt-3">
            Tu tranquilidad es nuestra prioridad. Ofrecemos vigilancia, monitoreo y protección profesional las 24 horas del día.
        </p>

        <a href="#" style="background-color: transparent; color: #DAA520; padding: 10px 20px;
          border: 2px solid #DAA520; border-radius: 25px; font-weight: bold;
          text-decoration: none; font-family: 'Segoe UI', sans-serif; display: inline-block;">Conoce nuestros servicios
        </a>
    </div>

    <hr class="my-5 text-light">

    <div class="row text-center">
        <div class="col-md-4">
            <h3 class="fw-bold" style="color:#DAA520;">Vigilancia 24/7</h3>
            <p class="text-light">Personal altamente capacitado para mantener segura tu empresa o residencia.</p>
        </div>
        <div class="col-md-4">
            <h3 class="fw-bold" style="color:#DAA520;">Tecnología Avanzada</h3>
            <p class="text-light">Sistemas de cámaras, alarmas y monitoreo inteligente.</p>
        </div>
        <div class="col-md-4">
            <h3 class="fw-bold" style="color: #DAA520;">Soporte Tecnico</h3>
            <p class="text-light">Nuestro equipo actúa con rapidez y eficacia ante cualquier incidente.</p>
        </div>
    </div>

    <footer class="bg-dark text-center text-light py-3">
        <p class="mb-0">© 2025 Grupo Centinela. Todos los derechos reservados.</p>
    </footer>
@endsection
