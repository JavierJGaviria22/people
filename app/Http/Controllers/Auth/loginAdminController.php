<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginAdminController extends Controller
{
    public function showLoginFormAdmin()
    {
        return view('admin.login');
    }

    public function iniciarSesionAdmin(Request $request)
    {
        // Cambiar 'password' a 'contrasena' para que coincida con el formulario
        $credentials = $request->only('correo', 'password');

        if (Auth::guard('g_administradores')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin'); // Redirige a la página del administrador
        }

        return redirect('/admin/login')->withErrors([
            'correo' => 'Las credenciales no coinciden.',
        ]);
    }

    public function cerrarSesionAdmin()
    {
        Auth::guard('g_administradores')->logout();
        return redirect('/admin/login');
    }
}
