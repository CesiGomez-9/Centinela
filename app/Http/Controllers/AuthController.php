<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'usuario' => ['required', 'string', 'min:3', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:64'],
        ], [
            'usuario.required' => 'Debe ingresar su usuario.',
            'password.required' => 'Debe ingresar su contraseña.',
            'password.min' => 'La contraseña no puede ser menor de 8 caracteres.',
            'password.max' => 'La contraseña no puede ser mayor a 64 caracteres.',
            'usuario.min' => 'El usuario debe tener al menos 3 caracteres.',
            'usuario.max' => 'El usuario no debe ser mas 50 caracteres.',
        ]);

        $credentials = $request->only('usuario', 'password');

        // 1. Validamos credenciales SIN iniciar sesión
        if (Auth::validate($credentials)) {
            $user = \App\Models\User::where('usuario', $request->usuario)->first();

            // 2. ¿Tiene el 2FA activado?
            if ($user->two_factor_enabled) {
                // Guardamos el ID en sesión temporal para el TwoFactorController
                session(['two_factor_pending_user' => $user->id]);

                // Opcional: Guardar si quería "recordarme" para aplicarlo después del 2FA
                if ($request->filled('remember')) {
                    session(['two_factor_remember' => true]);
                }

                return redirect()->route('two-factor.verify');
            }

            // 3. Si NO tiene 2FA, iniciamos sesión normalmente
            Auth::login($user, $request->filled('remember'));

            // CORRECCIÓN INCIDENCIA #2: Regenerar ID de sesión
            $request->session()->regenerate();

            return redirect()->route('index');
        }

        // 4. Fallo de seguridad: Retraso intencional
        usleep(500000);

        return back()->withErrors([
            'usuario' => 'Credenciales incorrectas.',
        ])->withInput($request->except('password'));
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
