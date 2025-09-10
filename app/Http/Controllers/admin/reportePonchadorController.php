<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZonasHorarias;
use App\Models\Sedes;
use App\Models\ReportePonchador;
use App\Models\AuditInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class reportePonchadorController extends Controller
{
    public function index()
    {
        // $reporte_ponchador = ReportePonchador::all();
        /*$reporte_ponchador =  DB::table('z_info_horas_trabajadas as z')
        ->select(
            'd.nombre as departamento',
            'z.id_empleado',
            DB::raw("CONCAT(e.apellido, ' ', e.nombre) as empleado"),
            'z.fecha',
            'z.entradas',
            'z.tiempo_e',
            'z.salidas',
            'z.tiempo_s',
            'z.total_trabajado',
            'h.total',
            'z.notas',
            'z.observaciones'
        )
        ->join('empleados as e', 'e.id_empleado', '=', 'z.id_empleado')
        ->join('departamentos as d', 'd.id_departamento', '=', 'e.id_departamento')
        ->leftJoin('pd_horarios as h', function ($join) {
            $join->on('h.id_empleado', '=', 'z.id_empleado')
                 ->on('z.fecha', '=', 'h.fecha_h');
        })
        ->whereBetween('z.fecha', [Carbon::now()->subDays(30), Carbon::now()])
        ->orderBy('empleado')
        ->orderBy('z.fecha')
        ->orderBy('z.tiempo_e', 'ASC')
        ->get();*/

        $inconsistencias = DB::table('z_reporte_ponchador AS z')
            ->whereBetween('z.fecha', [Carbon::now()->subDays(30), Carbon::now()])
            ->where('z.fecha', '<>', today())
            ->get();

        return view('admin.reporte-horas-trabajadas', compact('inconsistencias'));
    }

    public function create()
    {
        $sedes = ZonasHorarias::all();

        return view('admin.nueva-sede', compact('sedes'));
    }

    public function store(Request $request)
    {
        $zonasPermitidas = ZonasHorarias::pluck('id_zona_horaria')->toArray();

        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
            'zonah' => ['required', 'in:' . implode(',', $zonasPermitidas)],

        ], [
            'nombre.required' => 'Nombre requerido',
        ]);

        $count = Sedes::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('nombre', $request->input('nombre'))
            ->where('activo', 1)
            ->count();

        if ($count >= 1) {
            return redirect()->route('departamentos.create')->with('error', 'Esta sede ya existe');
        }

        $nuevaSede = new Sedes();
        $nuevaSede->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevaSede->id_zona_horaria = $request->input('zonah');
        $nuevaSede->nombre = $request->input('nombre');
        $nuevaSede->direccion = $request->input('direccion');
        $nuevaSede->correo = $request->input('correo');
        $nuevaSede->telefono = $request->input('telefono');
        $nuevaSede->fecha_creacion = now();
        $nuevaSede->creado_por = auth('g_administradores')->user()->id_admin;
        $nuevaSede->save();

        return redirect()->route('sedes.create')->with('success', 'Sede creada correctamente');
    }

    public function edit($id_sede)
    {

        $sede = Sedes::where('id_sede', $id_sede)->first();
        $zonas = ZonasHorarias::all();
        // $diasLaborales = explode(',', $sede->dias_laborales);

        if (!$sede) {
            return redirect()->route('contratos.index');
        }

        return view('admin.editar-sede', compact('sede', 'zonas'));
    }

    public function update(Request $request, $id_sede)
    {
        $sede = Sedes::where('id_sede', $id_sede)->first();
        $zonasPermitidas = ZonasHorarias::pluck('id_zona_horaria')->toArray();

        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
            'zonah' => ['required', 'in:' . implode(',', $zonasPermitidas)],

        ], [
            'nombre.required' => 'Nombre requerido',
        ]);

        $count = Sedes::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('nombre', $request->input('nombre'))
            ->where('activo', 1)
            ->whereNot('id_sede', $id_sede)
            ->count();

        if ($count >= 1) {
            return redirect()->route('sedes.edit', $id_sede)->with('error', 'Esta sede ya existe');
        }

        $sede->nombre = $request->input('nombre');
        $sede->id_zona_horaria = $request->input('zonah');
        $sede->correo = $request->input('correo');
        $sede->telefono = $request->input('telefono');
        $sede->direccion = $request->input('direccion');
        $sede->fecha_actualizacion = now();
        $sede->actualizado_por = auth('g_administradores')->user()->id_admin;
        $sede->save();

        return redirect()->route('sedes.edit', $sede->id_sede)->with('success', 'Sede actualizada correctamente');
    }

    //show es el metodo para desactivar la noticia ¡importante!
    public function show($id_sede)
    {
        $sede = Sedes::where('id_sede', $id_sede)->first();

        $sede->activo = 0;
        $sede->fecha_actualizacion = now();
        $sede->actualizado_por = auth('g_administradores')->user()->id_admin;
        $sede->save();

        return redirect()->route('sedes.index', $sede->id_sede)->with('success', 'Sede eliminada correctamente');
    }

    public function audit_log()
    {
        $audits = AuditInfo::whereBetween('fecha_modificacion', [date('Y-m-d', strtotime('-30 days')), date('Y-m-d')])->get();

        return view('admin.audit-log', compact('audits'));
    }
}
