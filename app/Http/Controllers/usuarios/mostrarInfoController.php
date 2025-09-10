<?php

namespace App\Http\Controllers\usuarios;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\noticias;
use App\Models\InfoEmpleados;

class mostrarInfoController extends Controller
{
    public function index()
    {
        $noticias = noticias::where('fecha_fin', '>=', '2024-09-17')->get();
        return view('usuarios.noticias', compact('noticias')); // Pasar las noticias a la vista
    }

    public function userPerfil()
    {
        $info_empleado = InfoEmpleados::where('id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)->first();
        return view('usuarios.mi-perfil', compact('info_empleado'));
    }

    public function pagesFaq()
    {
        return view('usuarios.preguntas-frecuentes');
    }
}
