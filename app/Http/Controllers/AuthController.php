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
            'password' => ['required', 'string', 'min:6', 'max:64'],
        ], [
            'usuario.required' => 'Debe ingresar su usuario.',
            'password.required' => 'Debe ingresar su contraseña.',
            'password.min' => 'La contraseña no puede ser menor de 6 caracteres.',
            'password.max' => 'La contraseña no puede ser mayor a 64 caracteres.',
            'usuario.min' => 'El usuario debe tener al menos 3 caracteres.',
            'usuario.max' => 'El usuario no debe ser mas 50 caracteres.',
        ]);


        $credentials = $request->only('usuario', 'password');

        $user = User::where('usuario', $request->usuario)->first();

        if (!$user) {
            return back()->withErrors([
                'usuario' => 'El usuario es incorrecto.',
            ])->withInput($request->except('password'));
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Si el usuario tiene 2FA activo, pausar y pedir código
            if ($user->hasTwoFactorEnabled()) {
                $request->session()->put('two_factor_pending_user', $user->id);
                Auth::logout();
                return redirect()->route('two-factor.verify');
            }

            // Marcar sesión como verificada (sin 2FA)
            $request->session()->put('two_factor_verified', true);
            return redirect()->route('index');
        }

        // Retraso intencional para mitigar ataques de fuerza bruta
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
