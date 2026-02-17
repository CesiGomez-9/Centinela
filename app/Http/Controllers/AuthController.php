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
            'usuario' => ['required', 'string'],
            'password' => ['required', 'string', 'max:20'],
        ], [
            'usuario.required'  => 'Debe ingresar su usuario.',
            'password.required' => 'Debe ingresar su contraseña.',
            'password.max'      => 'La contraseña no puede ser mayor a 20 caracteres.',
        ]);


        $credentials = $request->only('usuario', 'password');


        $user = User::where('usuario', $request->usuario)->first();

        if (!$user) {
            return back()->withErrors([
                'usuario' => 'El usuario es incorrecto.',
            ])->withInput($request->except('password'));
        }


        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ])->withInput($request->except('password'));
        }


        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
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

        return redirect('login');
    }
}
