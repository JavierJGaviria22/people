<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InfoEmpleados;
use App\Models\InfoFichaje;
use App\Models\InfoFichajePermisos;
use App\Models\EstadosFichaje;
use App\Models\Permisos;
use App\Models\InfoPermisos;
use App\Models\TipoPermiso;
use Carbon\Carbon;


class fichajeController extends Controller
{
    public function index()
    {
        $fechaUltimoEstado = null;
        $fechaActual = null;
        $minFechaAusencia = null;
        $maxFechaAusencia = null;
        $intervaloDias = null;
        $tiposPermiso = null;

        //Tipo del ultimo registro del usuario autenticado
        $ultimoTipoEstado = DB::table('pd_info')
            ->join('pd_estados', 'pd_estados.id_estado', '=', 'pd_info.id_estado')
            ->where('pd_info.id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)
            ->orderBy('pd_info.tiempo', 'desc')
            ->limit(1)
            ->value('pd_estados.tipo_estado');
        if ($ultimoTipoEstado == 'ausencia' || $ultimoTipoEstado == null) {
            $ultimoTipoEstado = 'out';
        }

        // $permisosHoy = InfoPermisos::where('id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)
        //     ->where('estado', 'Aprobado')
        //     ->whereDate('fecha_inicio', now()->toDateString())
        //     ->whereDate('fecha_fin', now()->toDateString())
        //     ->get();

        $permisosHoy = DB::table('z_info_permisos as p')
            ->leftJoin('z_info_permiso_ponchado as pp', 'pp.id_permiso', '=', 'p.id_permiso')
            ->select('p.id_permiso', 'p.id_empleado', 'p.regresa', 'p.id_permiso', 'p.permiso', 'fecha_inicio','p.estado')
            ->whereDate('p.fecha_inicio', '=', now()->toDateString())
            ->whereNull('pp.salidas')
            ->orderBy('fecha_inicio', 'asc')
            ->limit(1)
            ->get();


        $estadosPermiso = DB::table('pd_info_permisos')
            ->where('id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)
            // ->where('id_permiso', $permisosHoy->id_permiso)
            ->whereNull('fecha_eliminacion')
            ->whereDate('tiempo', now()->toDateString())
            ->orderBy('id_pd_info_permisos', 'desc')
            ->limit(1)
            ->value('estado');

        if ($estadosPermiso == null) {
            $estadosPermiso = 'fin';
        }

        $estados = DB::table('pd_estados')
            ->where('id_empresa', auth('g_usuarios')->user()->empleado->id_empresa)
            ->whereNull('fecha_eliminacion')
            ->where('tipo_estado', '<>', $ultimoTipoEstado)
            ->get();

        $fichaTiempo = InfoFichaje::join('pd_estados', 'pd_info.id_estado', '=', 'pd_estados.id_estado')
            ->where('pd_info.id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)
            ->where('pd_info.fecha_eliminacion', null)
            ->whereDate('pd_info.tiempo', now()->toDateString())
            ->orderBy('pd_info.tiempo', 'asc')
            ->get();

        $fichaPermiso = InfoFichajePermisos::where('id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)
            ->where('fecha_eliminacion', null)
            ->whereDate('tiempo', now()->toDateString())
            ->get();

        //Tipo del ultimo registro sin incluir la fecha actual del usuario autenticado
        $ultimoEstado = DB::table('pd_info')
            ->join('pd_estados', 'pd_estados.id_estado', '=', 'pd_info.id_estado')
            ->where('pd_info.id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)
            ->whereRaw('DATE(pd_info.tiempo) <> ?', [today()->toDateString()])
            ->orderBy('pd_info.tiempo', 'desc')
            ->limit(1)
            ->first();
        if ($ultimoEstado === null) {
            // Si no se encontró el último estado, asignamos un valor predeterminado al color
            $ultimoEstado = (object) [

                'color' => 'black',
                'estado' => 'Nuevo',
                'tipo_estado' => 'out',
                'tiempo' => \Carbon\Carbon::parse(now())->format('Y-m-d'),

            ];
        } else {
            // Convierte a un objeto Carbon sin la parte de la hora usando startOfDay()
            $fechaUltimoEstado = Carbon::parse($ultimoEstado->tiempo)->startOfDay(); // Ignora la hora
            $fechaActual = Carbon::now()->startOfDay(); // Obtiene la fecha actual sin la hora
            $minFechaAusencia = \Carbon\Carbon::parse($ultimoEstado->tiempo)->startOfDay()->addDay()->format('Y-m-d H:i');
            $maxFechaAusencia = \Carbon\Carbon::parse(now())->subDay()->startOfDay()->format('Y-m-d H:i');

            // Calcula la diferencia en días
            $intervaloDias = $fechaUltimoEstado->diffInDays($fechaActual);
        }

        $tiposPermiso = TipoPermiso::where('id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)
            ->select('tipo_permiso.id_tipo_permiso', 'tipo_permiso.permiso')
            ->get();
        // dd($ultimoEstado);
        return view('usuarios.fichaje', compact('estadosPermiso', 'tiposPermiso', 'maxFechaAusencia', 'minFechaAusencia', 'intervaloDias', 'ultimoEstado', 'estados', 'fichaTiempo', 'fichaPermiso', 'permisosHoy'));
    }

    public function agregarCorreccion(Request $request)
    {
        $ultimoEstado = DB::table('pd_info')
            ->join('pd_estados', 'pd_estados.id_estado', '=', 'pd_info.id_estado')
            ->where('pd_info.id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)
            ->whereRaw('DATE(pd_info.tiempo) <> ?', [today()->toDateString()])
            ->orderBy('pd_info.tiempo', 'desc')
            ->limit(1)
            ->first();

        $request->validate([
            'correccion' => 'required|date_format:H:i|after_or_equal:' . \Carbon\Carbon::parse($ultimoEstado->tiempo)->format('H:i'),
        ], [
            'estado-correccion.date' => 'La hora debe ser mayor a la del ultimo estado',
        ]);

        $fechaUltimoEstado = \Carbon\Carbon::parse($ultimoEstado->tiempo)->format('Y-m-d');
        $horaCorreccion = $request->input('correccion'); // Hora proporcionada en formato H:i

        $nuevaFechaHora = \Carbon\Carbon::parse($fechaUltimoEstado . ' ' . $horaCorreccion);

        $nuevaInfo = new InfoFichaje();
        $nuevaInfo->id_empresa = auth('g_usuarios')->user()->empleado->id_empresa;
        $nuevaInfo->id_empleado = auth('g_usuarios')->user()->empleado->id_empleado;
        $nuevaInfo->id_estado = 1;
        $nuevaInfo->tiempo = $nuevaFechaHora;
        $nuevaInfo->latitude = $request->input('latitudeModal');
        $nuevaInfo->longitude = $request->input('longitudeModal');
        $nuevaInfo->save();

        return redirect()->route('fichaje')->with('success', 'Corrección registrada correctamente');
    }

    public function agregarAusencia(Request $request)
    {
        /*$ultimoEstado = DB::table('pd_info')
            ->join('pd_estados', 'pd_estados.id_estado', '=', 'pd_info.id_estado')
            ->where('pd_info.id_empleado', auth('g_usuarios')->user()->empleado->id_empleado)
            ->whereRaw('DATE(pd_info.tiempo) <> ?', [today()->toDateString()])
            ->orderBy('pd_info.id_pd_info', 'desc')
            ->limit(1)
            ->first();

        $request->validate([
            'correccion' => 'required|date_format:H:i|after_or_equal:' . \Carbon\Carbon::parse($ultimoEstado->tiempo)->format('H:i'),
        ], [
            'estado-correccion.date' => 'La hora debe ser mayor a la del ultimo estado',
        ]);*/

        $fechaInicio = Carbon::parse($request->input('fecha_inicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fecha_fin'))->startOfDay();
        $intervaloDias = $fechaInicio->diffInDays($fechaFin);

        // dd(Carbon::parse($request->input('fecha_inicio')));

        for ($i = 0; $i <= $intervaloDias; $i++) {
            
            if (Carbon::parse($request->input('fecha_inicio')) == today()) {
            continue;
        }
        
            $nuevaInfo = new InfoFichaje();
            $nuevaInfo->id_empresa = auth('g_usuarios')->user()->empleado->id_empresa;
            $nuevaInfo->id_empleado = auth('g_usuarios')->user()->empleado->id_empleado;
            $nuevaInfo->id_estado = 2;
            $nuevaInfo->tiempo = $fechaInicio;
            $nuevaInfo->notas = $request->input('motivo');
            $nuevaInfo->latitude = $request->input('latitudeModal');
            $nuevaInfo->longitude = $request->input('longitudeModal');
            $nuevaInfo->save();
            $fechaInicio = $fechaInicio->addDay();
        }

        return redirect()->route('fichaje')->with('success', 'Motivos de ausencia registrados correctamente');
    }

    public function agregarInfo(Request $request)
    {
        $estadosPermitidos = EstadosFichaje::where('id_empresa', auth('g_usuarios')->user()->empleado->id_empresa)->pluck('id_estado')->toArray();

        $request->validate([
            'estado-info' => ['in:' . implode(',', $estadosPermitidos)],
        ], [
            'estado-info.in' => 'Estado no permitido',
        ]);

        $nuevaInfo = new InfoFichaje();
        $nuevaInfo->id_empresa = auth('g_usuarios')->user()->empleado->id_empresa;
        $nuevaInfo->id_empleado = auth('g_usuarios')->user()->empleado->id_empleado;
        $nuevaInfo->id_estado = $request->input('estado-info');
        $nuevaInfo->tiempo = now()->setSecond(0)->setMillisecond(0);
        $nuevaInfo->notas = $request->input('nota');
        $nuevaInfo->ipaddress = $_SERVER['REMOTE_ADDR'];
        $nuevaInfo->latitude = $request->input('latitude');
        $nuevaInfo->longitude = $request->input('longitude');
        $nuevaInfo->save();

        return redirect()->route('fichaje')->with('success', 'Estado registrado correctamente');
    }

    public function agregarInfoPermiso(Request $request)
    {
        $estadosPermitidos = ['inicio', 'fin'];

        $request->validate([
            'estado-info' => ['in:' . implode(',', $estadosPermitidos)],
        ], [
            'estado-info.in' => 'Estado no permitido',
        ]);

        $nuevaInfo = new InfoFichajePermisos();
        $nuevaInfo->id_empresa = auth('g_usuarios')->user()->empleado->id_empresa;
        $nuevaInfo->id_empleado = auth('g_usuarios')->user()->empleado->id_empleado;
        $nuevaInfo->id_permiso = $request->input('id_permiso');
        $nuevaInfo->estado = $request->input('estado-permiso');
        $nuevaInfo->tiempo = now();
        $nuevaInfo->notas = $request->input('nota');
        $nuevaInfo->latitude = $request->input('latitudep');
        $nuevaInfo->longitude = $request->input('longitudep');
        $nuevaInfo->save();

        return redirect()->route('fichaje')->with('success', 'Estado registrado correctamente');
    }

    public function deshacerUltimoEstado($id_pd_info)
    {
        $info = InfoFichaje::where('id_pd_info', $id_pd_info)->first();

        if (!$info || $info->id_empleado != auth('g_usuarios')->user()->empleado->id_empleado) {
            return redirect()->route('fichaje');
        }
        
        if (Carbon::parse($info->tiempo)->diffInMinutes(Carbon::now()) >= 2) {
            return redirect()->route('fichaje')->with('error', 'Se ha exedido el tiempo permitido');
        }

        $info->delete();
         

        return redirect()->route('fichaje')->with('success', 'El registro ha sido eliminado');
    }

    public function deshacerUltimoEstadoPermiso($id_pd_info_permisos)
    {
        $info = InfoFichajePermisos::where('id_pd_info_permisos', $id_pd_info_permisos)->first();

        if (!$info || $info->id_empleado !== auth('g_usuarios')->user()->empleado->id_empleado) {
            return redirect()->route('fichaje');
        }

        $info->delete();

        return redirect()->route('fichaje')->with('success', 'El registro ha sido eliminado');
    }
}
