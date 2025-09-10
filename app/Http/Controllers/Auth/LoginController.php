<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('usuarios.login');
    }

    public function iniciarSesion()
    {
        $credentials = request()->only('usuario', 'contrasena');
        $credentials['password'] = $credentials['contrasena'];
        unset($credentials['contrasena']); // Eliminar 'contrasena' si ya no es necesaria
        if (Auth::guard('g_usuarios')->attempt($credentials)) {
            request()->session()->regenerate();
            return redirect('/');
        }
        return redirect('login');
    }

    public function cerrarSesion()
    {
        Auth::guard('g_usuarios')->logout(); // Cerrar sesión del guard personalizado
        return redirect('/login'); // Redirigir a la página de inicio o login
    }
}
