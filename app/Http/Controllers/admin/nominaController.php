<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AuditInfo;
use Illuminate\Http\Request;
use App\Models\ZonasHorarias;
use App\Models\InfoFichaje;
use App\Models\EstadosFichaje;
use App\Models\Observaciones;
use Illuminate\Support\Facades\DB;

class nominaController extends Controller
{
    public function index()
    {
        return view('admin.inconsistencias');
    }

    public function showInconsistencias($start_date, $end_date)
    {

        $fecha_inicio = $start_date;
        $fecha_fin = $end_date;

        $inconsistencias = DB::table('z_reporte_ponchador AS z')
            ->whereRaw('(z.total_trabajado - CONVERT(z.total_asignado, DECIMAL(10,2))) * 60 NOT BETWEEN -2 AND 2')
            ->where('z.total_asignado', '<>', '-')
            ->where('z.fecha', '>=', $fecha_inicio)
            ->where('z.fecha', '<=', $fecha_fin)
            ->where('z.fecha', '<>', today())
            ->get();

        return view('admin.informe-inconsistencias', compact('inconsistencias'));
    }

    public function edit($id_empleado, $fecha)
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
                     DATE(i.tiempo) AS fecha, TIME(i.tiempo) AS hora, i.notas, i.observacion, i.latitude, i.longitude")
            ->join('empleados as e', 'e.id_empleado', '=', 'i.id_empleado')
            ->join('pd_estados as pe', 'pe.id_estado', '=', 'i.id_estado')
            ->where('i.id_empleado', $id_empleado)
            ->whereDate('i.tiempo', $fecha)
            ->orderby(DB::raw('TIME(i.tiempo)'), 'asc')
            ->get();

        $observaciones = Observaciones::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 1)
            ->get();

        $tipoEstados =  EstadosFichaje::where('id_empresa', auth('g_administradores')->user()->id_empresa)->get();

        $ubicacion = null;

        return view('admin.ajustar-inconsistencias', compact('horario', 'estados', 'tipoEstados', 'observaciones', 'ubicacion'));
    }

    public function update(Request $request)
    {
        // -> Agregar logica para insertar audit log <-
        $i = $request->input('i');
        $fecha = $request->input('fecha');

        for ($f = 1; $f < $i; $f++) {
            $nuevaHora = InfoFichaje::where('id_pd_info', $request->input('id_pd_info' . $f))->first();
            if ($request->input('observacion' . $f) == 'nulo') {
                $nuevaHora->observacion = null;
            } else {
                $nuevaHora->observacion = $request->input('observacion' . $f);
            }
            $nuevaHora->save();
            if ($request->input('nueva_hora' . $f) == null) {
                continue;
            } else {

                $auditlog = new AuditInfo();
                $auditlog->modificado_por_ip = $_SERVER['REMOTE_ADDR'];
                $auditlog->modificado_por_usuario = auth('g_administradores')->user()->nombre;
                $auditlog->fecha_modificacion = now();
                $auditlog->modificado_de = $nuevaHora->tiempo;

                $nuevaHora->tiempo = $fecha . ' ' . $request->input('nueva_hora' . $f);
                $nuevaHora->fecha_actualizacion = now();
                $nuevaHora->actualizado_por = auth('g_administradores')->user()->id_admin;
                $nuevaHora->save();

                $auditlog->modificado_a = $nuevaHora->tiempo;
                $auditlog->usuario_modificado = $request->input('nombre_empleado');
                $auditlog->save();
            }
        }
        return back()->with('success', 'Operación realizada con éxito!');
    }

    //show es el metodo para elimnar un estado de ponchador ¡importante!
    public function show($id_estado)
    {
        $estado = InfoFichaje::where('id_pd_info', $id_estado)->first();

        if (!$estado) {
            return back()->with('error', 'Estado no encontrado.');
        }

        $estado->delete();

        return back()->with('success', 'Estado Eliminado Correctamente.');
    }

    public function agregarEstado(Request $request)
    {
        $FechaHora = \Carbon\Carbon::parse($request->input('fecha') . ' ' . $request->input('hora'));


        $nuevaEstado = new InfoFichaje();
        $nuevaEstado->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevaEstado->id_empleado = $request->input('id_empleado');
        $nuevaEstado->id_estado = $request->input('tipo_estado');
        $nuevaEstado->tiempo = $FechaHora;
        $nuevaEstado->notas = 'Agregado por Admin';
        $nuevaEstado->ipaddress = $_SERVER['REMOTE_ADDR'];
        $nuevaEstado->fecha_actualizacion = now();
        $nuevaEstado->actualizado_por = auth('g_administradores')->user()->id_admin;
        $nuevaEstado->save();

        return back()->with('success', 'Estado Agregado Correctamente.');
    }

    public function showubicacion($id_pd_info)
    {
        $ubicacion = InfoFichaje::where('id_pd_info', $id_pd_info)->first();
        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicación no encontrada'], 404);
        }
        return response()->json([
            'latitude' => $ubicacion->latitude,
            'longitude' => $ubicacion->longitude,
            'nombre_empleado' => $ubicacion->nombre_empleado
        ]);
    }


}
