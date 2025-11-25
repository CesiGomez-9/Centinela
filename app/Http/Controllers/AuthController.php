<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => ['required', 'string'],
            'password' => ['required', 'string', 'max:20'],
        ], [
            'usuario.required'  => 'Debe ingresar su usuario.',
            'password.required' => 'Debe ingresar su contraseña.',
            'password.max'=>'La contraseña no puede ser mayor a 20 caracteres.',
        ]);

        // Tomamos solo usuario y contraseña
        $credentials = $request->only('usuario', 'password');

        // Intento de login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirigir al index
            return redirect()->route('index');
        }


        return back()->withErrors([
            'usuario' => 'Credenciales incorrectas.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth');
    }
}
