@extends('plantilla')
@section('content')

<style>
    body { background-color: #e6f0ff; font-family: 'Inter', sans-serif; }

    .perm-container {
        max-width: 1100px;
        margin: 40px auto;
    }

    /* Cabecera del usuario */
    .user-card {
        background: linear-gradient(135deg, #0A1F44, #1a2f5e);
        border-radius: 1rem;
        padding: 24px 30px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 24px;
    }

    .user-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background-color: #cda34f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #0A1F44;
        flex-shrink: 0;
    }

    .user-details { flex: 1; min-width: 200px; }
    .user-details h4 { margin: 0 0 4px; font-size: 1.2rem; font-weight: 700; }
    .user-details .sub { color: #aac4e8; font-size: 0.88rem; margin: 2px 0; }

    .badge-rol {
        display: inline-block;
        background-color: #cda34f;
        color: #0A1F44;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 700;
        margin: 2px 4px 2px 0;
    }

    .badge-sinrol {
        display: inline-block;
        background-color: #6c757d;
        color: #fff;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.82rem;
    }

    /* Leyenda */
    .leyenda {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #fff;
        border-radius: 0.6rem;
        padding: 10px 18px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        font-size: 0.85rem;
        color: #444;
    }

    .leyenda-item { display: flex; align-items: center; gap: 7px; }

    /* Contador resumen */
    .resumen-bar {
        background: #fff;
        border-radius: 0.6rem;
        padding: 10px 18px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        font-size: 0.85rem;
        color: #444;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .resumen-bar .progreso {
        flex: 1;
        height: 8px;
        background: #e0e0e0;
        border-radius: 4px;
        overflow: hidden;
    }

    .resumen-bar .progreso-fill {
        height: 100%;
        background: linear-gradient(90deg, #28a745, #5cb85c);
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    /* Grid de módulos */
    .modulos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 16px;
    }

    .modulo-card {
        background: #fff;
        border-radius: 0.8rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.2s;
    }

    .modulo-card:hover { transform: translateY(-2px); }

    .modulo-header {
        padding: 10px 14px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modulo-header.tiene-permisos {
        background: linear-gradient(135deg, #1a7a3e, #28a745);
        color: #fff;
    }

    .modulo-header.sin-permisos {
        background: #e9ecef;
        color: #888;
    }

    .modulo-body { padding: 10px 14px; }

    /* Cada permiso */
    .permiso-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.85rem;
    }

    .permiso-row:last-child { border-bottom: none; }

    .permiso-row.activo { color: #1a5c2e; }
    .permiso-row.inactivo { color: #bbb; }

    .check-icon {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    .check-icon.activo {
        background-color: #28a745;
        color: #fff;
    }

    .check-icon.inactivo {
        background-color: #e9ecef;
        color: #ccc;
    }

    /* Botón */
    .btn-volver {
        background-color: #0A1F44;
        color: #fff;
        border: none;
        padding: 0.6rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: background 0.2s;
        text-decoration: none;
    }

    .btn-volver:hover { background-color: #cda34f; color: #0A1F44; }
</style>

<div class="perm-container">

    {{-- Cabecera usuario --}}
    <div class="user-card">
        <div class="user-avatar">
            <i class="bi bi-person-fill"></i>
        </div>
        <div class="user-details">
            <h4>{{ $user->empleado->nombre }} {{ $user->empleado->apellido }}</h4>
            <p class="sub"><i class="bi bi-person-badge me-1"></i>{{ $user->usuario }}</p>
            <p class="sub"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>
        </div>
        <div>
            <div style="font-size:0.78rem; color:#aac4e8; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Rol asignado</div>
            @forelse($user->roles as $role)
                <span class="badge-rol"><i class="bi bi-shield-fill me-1"></i>{{ $role->name }}</span>
            @empty
                <span class="badge-sinrol">Sin rol</span>
            @endforelse
        </div>
    </div>

    @if($user->roles->isEmpty())
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Este usuario no tiene roles asignados, por lo tanto no tiene permisos.
        </div>
    @else

        @php
            $totalPermisos = collect($permisosPorModulo)->flatten()->count();
            $totalActivos  = collect($permisosPorModulo)->flatten()->filter(fn($p) => $permisosDelUsuario->contains($p))->count();
            $porcentaje    = $totalPermisos > 0 ? round(($totalActivos / $totalPermisos) * 100) : 0;
        @endphp

        {{-- Barra de resumen --}}
        <div class="resumen-bar">
            <i class="bi bi-shield-check text-success fs-5"></i>
            <span><strong>{{ $totalActivos }}</strong> de <strong>{{ $totalPermisos }}</strong> permisos activos ({{ $porcentaje }}%)</span>
            <div class="progreso">
                <div class="progreso-fill" style="width: {{ $porcentaje }}%"></div>
            </div>
        </div>

        {{-- Leyenda --}}
        <div class="leyenda">
            <span style="font-weight:600;">Leyenda:</span>
            <div class="leyenda-item">
                <div class="check-icon activo"><i class="bi bi-check"></i></div>
                <span>Permiso activo</span>
            </div>
            <div class="leyenda-item">
                <div class="check-icon inactivo"><i class="bi bi-x"></i></div>
                <span>Sin permiso</span>
            </div>
        </div>

        {{-- Grid de módulos --}}
        <div class="modulos-grid">
            @foreach($permisosPorModulo as $modulo => $permisos)
                @php
                    $activosEnModulo = collect($permisos)->filter(fn($p) => $permisosDelUsuario->contains($p))->count();
                    $tieneAlguno     = $activosEnModulo > 0;
                @endphp
                <div class="modulo-card">
                    <div class="modulo-header {{ $tieneAlguno ? 'tiene-permisos' : 'sin-permisos' }}">
                        <span><i class="bi bi-grid-3x3-gap me-1"></i>{{ $modulo }}</span>
                        <span style="font-size:0.75rem; opacity:0.85;">{{ $activosEnModulo }}/{{ count($permisos) }}</span>
                    </div>
                    <div class="modulo-body">
                        @foreach($permisos as $permiso)
                            @php $activo = $permisosDelUsuario->contains($permiso); @endphp
                            <div class="permiso-row {{ $activo ? 'activo' : 'inactivo' }}">
                                <div class="check-icon {{ $activo ? 'activo' : 'inactivo' }}">
                                    <i class="bi bi-{{ $activo ? 'check' : 'x' }}"></i>
                                </div>
                                <span>{{ ucfirst($permiso) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    @endif

    <div class="text-center mt-4">
        <a href="{{ route('users.index') }}" class="btn-volver">
            <i class="bi bi-arrow-left me-2"></i>Volver a la lista
        </a>
    </div>

</div>

@endsection
