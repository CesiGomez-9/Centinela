@extends('plantilla')
@section('titulo', 'Gestionar 2FA')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .card-manage { border:none; border-radius:1.25rem; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.2); max-width:500px; }
    .card-header-m { background-color:#0d1b2a; padding:1.5rem 1.75rem; border-bottom:4px solid #cda34f; }
    .card-header-m h5 { color:#fff; font-weight:700; font-size:1.2rem; margin:0; }
    .status-badge { background:#d4edda; color:#155724; border-radius:20px; padding:0.3rem 0.9rem; font-size:0.85rem; font-weight:600; }
    .btn-gold { background-color:#cda34f; color:#fff; border:none; border-radius:8px; padding:0.65rem 1.5rem; font-weight:600; transition:background 0.2s; }
    .btn-gold:hover { background-color:#0d1b2a; color:#fff; }
    .btn-danger-custom { background-color:#c0392b; color:#fff; border:none; border-radius:8px; padding:0.65rem 1.5rem; font-weight:600; }
    .btn-danger-custom:hover { background-color:#922b21; color:#fff; }
    .form-control:focus { border-color:#cda34f; box-shadow:0 0 0 3px rgba(205,163,79,0.2); }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card-manage">
                <div class="card-header-m">
                    <h5><i class="bi bi-shield-lock me-2"></i>Autenticación de Dos Factores</h5>
                </div>
                <div class="p-4">

                    @if(session('status'))
                        <div class="alert alert-success rounded-3 mb-3">
                            <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
                        </div>
                    @endif

                    <div class="d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-shield-check text-success fs-4"></i>
                        <span class="status-badge"><i class="bi bi-check2 me-1"></i>2FA Activado</span>
                    </div>

                    <p class="text-muted small mb-4">
                        Tu cuenta está protegida con autenticación de dos factores.
                        Para desactivarla ingresa tu contraseña actual.
                    </p>

                    <div class="mb-3">
                        <a href="{{ route('two-factor.recovery-codes') }}" class="btn-gold">
                            <i class="bi bi-key me-2"></i>Ver códigos de recuperación
                        </a>
                    </div>

                    <hr>

                    <form method="POST" action="{{ route('two-factor.disable') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-danger">
                                <i class="bi bi-exclamation-triangle me-1"></i>Desactivar 2FA
                            </label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Ingresa tu contraseña para confirmar">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn-danger-custom">
                            <i class="bi bi-shield-x me-2"></i>Desactivar autenticación de dos factores
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
