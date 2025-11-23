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
            'password' => ['required', 'string', 'max:8'],
        ], [
            'usuario.required'  => 'Debe ingresar su usuario.',
            'password.required' => 'Debe ingresar su contraseña.',
            'password.max'=>'La contraseña no puede ser mayor a 8 caracteres.',
        ]);

        $credentials = $request->only('usuario', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }


        return back()->withErrors([
            'usuario' => 'Credenciales incorrectas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth');
    }
}
