<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportePonchador;
use App\Models\Empleados;
use App\Models\InfoEmpleados;
use App\Models\Observaciones;
use App\Models\EstadosFichaje;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class reporteAsistenciaController extends Controller
{
    public function index()
    {
        // dd(auth('g_usuarios')->user());
        $info_empleados = InfoEmpleados::where('id_empleado', auth('g_usuarios')->user()->id_empleado)->first();

        $departamentoAuth = Empleados::where('id_empleado', auth('g_usuarios')->user()->id_empleado)
        ->select('id_departamento')
        ->first();
    
        // se pasa a la vista como incosistencias pero realmente son todos los estados ponchados
        $inconsistencias = DB::table('z_reporte_ponchador AS z')
            ->whereBetween('z.fecha', [Carbon::now()->subDays(30), Carbon::now()])
            ->where('z.fecha', '<>', today())
            ->where('z.id_departamento', $departamentoAuth->id_departamento)
            ->get();

         if ($info_empleados && ($info_empleados->lider) !== null) {

            return view('usuarios.reporte-asistencia', compact('inconsistencias'));
        } else {
            return redirect('/');
        }
    }

    public function show($id_empleado, $fecha)
    {
       
        $horario = DB::table('pd_horarios as h')
            ->selectRaw('e.id_empleado, z.empleado, z.fecha,h.entrada_h AS entrada, h.salida_h AS salida, 
                     h.tiempo_fuera AS almuerzo, h.total AS total_asignado, z.total_trabajado, s.nombre as sede')
            ->join('empleados as e', 'e.id_empleado', '=', 'h.id_empleado')
            ->join('sedes as s', 's.id_sede', '=', 'h.id_sede')
            ->join('z_reporte_ponchador as z', function ($join) {
                $join->on('z.fecha', '=', 'h.fecha_h')
                    ->on('z.id_empleado', '=', 'h.id_empleado');
            })
            ->where('h.id_empleado', $id_empleado)
            ->where('h.fecha_h', $fecha)
            ->first();

        $estados = DB::table('pd_info as i')
            ->selectRaw("i.id_pd_info, CONCAT(e.nombre, ' ', e.apellido) AS empleado, pe.estado, 
                     DATE(i.tiempo) AS fecha, TIME(i.tiempo) AS hora, i.notas, i.observacion")
            ->join('empleados as e', 'e.id_empleado', '=', 'i.id_empleado')
            ->join('pd_estados as pe', 'pe.id_estado', '=', 'i.id_estado')
            ->where('i.id_empleado', $id_empleado)
            ->whereDate('i.tiempo', $fecha)
            ->orderby(DB::raw('TIME(i.tiempo)'), 'asc')
            ->get();

        $observaciones = Observaciones::where('id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)
            ->where('activo', 1)
            ->get();

        $tipoEstados =  EstadosFichaje::where('id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)->get();

        return view('usuarios.reporte-detalles', compact('horario', 'estados', 'tipoEstados', 'observaciones'));
    }

}
