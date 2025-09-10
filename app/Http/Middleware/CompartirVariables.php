<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\InfoEmpleados;
use App\Models\InfoAdmins;

class CompartirVariables
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (Auth::guard('g_usuarios')->check()) {
            $userId = Auth::guard('g_usuarios')->user()->id_empleado;

            // Obtener las notificaciones
            $notificaciones = DB::table('notificaciones as n')
                ->select(
                    'n.titulo',
                    'n.mensaje',
                    DB::raw('DATEDIFF(CURDATE(), n.fecha_creacion) AS hace')
                )
                ->where('n.id_empleado', $userId)
                ->whereNull('n.fecha_leido')
                ->get();

            // Contar las notificaciones
            $nro_notificaciones = $notificaciones->count();

            $info_empleados = InfoEmpleados::where('id_empleado', $userId)->first();

            // Compartir las variables con todas las vistas
            view()->share('notificaciones', $notificaciones);
            view()->share('nro_notificaciones', $nro_notificaciones);
            view()->share('info_empleados', $info_empleados);
            
        }

        if (Auth::guard('g_administradores')->check()) {
            $adminId = Auth::guard('g_administradores')->user()->id_admin;
            $empresaId = Auth::guard('g_administradores')->user()->id_empresa;
            $notificaciones=0;
            $nro_notificaciones=0;
            // Obtener las notificaciones
            /*$notificaciones = DB::table('notificaciones as n')
                ->select(
                    'n.titulo',
                    'n.mensaje',
                    DB::raw('DATEDIFF(CURDATE(), n.fecha_creacion) AS hace')
                )
                ->where('n.id_empleado', $userId)
                ->whereNull('n.fecha_leido')
                ->get();*/

            // Contar las notificaciones
            // $nro_notificaciones = $notificaciones->count();

            $info_admins = InfoAdmins::where('id_admin', $adminId)->first();
            $info_empleados = InfoEmpleados::where('id_empresa', $empresaId)->where('activo', 'Si')->get();

            // Compartir las variables con todas las vistas
            view()->share('notificaciones', $notificaciones);
            view()->share('nro_notificaciones', $nro_notificaciones);
            view()->share('info_empleados', $info_empleados);
            view()->share('info_admins', $info_admins);
            
        }

        return $next($request);
    }
}
