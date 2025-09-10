<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Noticias;
use App\Models\Permisos;
use App\Models\InfoEmpleados;
use App\Models\Usuario;

class homeController extends Controller
{
    public function index()
    {
        $noticias = Noticias::join('administradores', 'noticias.creado_por', '=', 'administradores.id_admin')
            ->whereRaw('? BETWEEN noticias.fecha_inicio AND noticias.fecha_fin', [today()])
            ->where('administradores.id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)
            ->select('noticias.*')
            ->get();

        $cumpleaños = InfoEmpleados::whereRaw('MONTH(fecha_nacimiento) = MONTH(CURDATE())')
            ->where('id_empresa',  auth('g_usuarios')->user()->empleado->administradores->id_empresa)
            ->get();

        $permisos = Permisos::where('id_empleado', auth('g_usuarios')->user()->id_empleado)
            ->count();

        $permisos_aprobados = Permisos::where('aprobado', 1)
            ->where('id_empleado', auth('g_usuarios')->user()->id_empleado)
            ->count();

        $permisos_pendientes = Permisos::where('pendiente', 1)
            ->where('id_empleado', auth('g_usuarios')->user()->id_empleado)
            ->count();
            
        $pass = auth('g_usuarios')->user()->contrasena;

        return view('usuarios.inicio', compact('pass','noticias', 'cumpleaños', 'permisos', 'permisos_aprobados', 'permisos_pendientes'));
    }
    
    public function actualizarPassword(Request $request)
    {
        $password = Usuario::where('id_empleado',auth('g_usuarios')->user()->id_empleado)->first();
        $password->contrasena = $request->input('newPass');
        $password->save(); 
        
        return redirect()->route('/');
    }

    public function testi(Request $request)
    {        
        return view('plantilla');
    }
}
