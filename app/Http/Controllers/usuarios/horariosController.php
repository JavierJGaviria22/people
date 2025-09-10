<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Sedes;
use App\Models\InfoEmpleados;
use App\Models\InfoPermisos;
use App\Models\Empleados;
use App\Models\TipoPermiso;
use App\Models\Horarios;
use Illuminate\Support\Facades\DB;

class horariosController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:g_usuarios');
    // }

    public function index()
    {
        if (isset(auth('g_usuarios')->user()->id_empleado)) {
            $info_empleados = InfoEmpleados::where('id_empleado', auth('g_usuarios')->user()->id_empleado)->first();
        }
        $info_horarios = Horarios::select(
            'h.id_horario',
            's.nombre AS sede',
            DB::raw('CONCAT(e.nombre, " ", e.apellido) AS empleado'),
            'h.fecha_h AS fecha',
            DB::raw('IFNULL(DATE_FORMAT(h.entrada_h, "%l:%i %p"), "-") AS entrada'),
            DB::raw('IFNULL(DATE_FORMAT(h.salida_h, "%l:%i %p"), "-") AS salida'),
            DB::raw('IFNULL(h.tiempo_fuera, "-") AS almuerzo'),
            'h.total',
            DB::raw('IFNULL(tp.permiso, "-") AS novedad')
        )
            ->from('pd_horarios as h')
            ->join('empleados as e', 'e.id_empleado', '=', 'h.id_empleado')
            ->join('sedes as s', 's.id_sede', '=', 'e.id_sede')
            ->leftJoin('tipo_permiso as tp', 'tp.id_tipo_permiso', '=', 'h.id_permiso')
            ->whereBetween('h.fecha_h', [now()->subDays(30), now()->addDays(30)])
            ->get();

        if (isset(auth('g_administradores')->user()->id_empresa)) {
            return view('admin.horarios', compact('info_horarios'));
        }

        if ($info_empleados && ($info_empleados->lider) !== null) {

            return view('usuarios.horarios', compact('info_horarios'));
        } else {
            return redirect('/');
        }
    }

    public function create(Request $request)
    {
        $metodo = $request->segment(count($request->segments()));
        if ($metodo == 'editar-horario') {
            $accion = 'Editar';
        } else $accion = 'Nuevo';

        if (isset(auth('g_usuarios')->user()->id_empleado)) {
            $empleados = Empleados::where('id_departamento', function ($query) {
                $query->select('id_departamento')
                    ->from('empleados')
                    ->where('id_empleado', auth('g_usuarios')->user()->id_empleado);
            })->get();
            return view('usuarios.nuevo-horario', compact('empleados', 'accion'));
        }
        $empleados = Empleados::where('activo', 1)->get();
        return view('admin.nuevo-horario', compact('empleados', 'accion'));
    }

    public function store(Request $request)
    {
        if (isset(auth('g_usuarios')->user()->id_empleado)) {
            $id_empleado2 = auth('g_usuarios')->user()->id_empleado;
            $id_empresa = auth('g_usuarios')->user()->empleado->administradores->id_empresa;

            $empleadosPermitidos = Empleados::where('id_departamento', function ($query) {
                $query->select('id_departamento')
                    ->from('empleados')
                    ->where('id_empleado', auth('g_usuarios')->user()->id_empleado);
            })
                ->pluck('id_empleado')->toArray();
            $request->validate([
                'empleado' => ['required', 'in:' . implode(',', $empleadosPermitidos)],
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',

            ], [
                'empleado.required' => 'Empleado requerido',
            ]);
        }
        if (isset(auth('g_administradores')->user()->id_empresa)) {
            $id_empleado2 = null;
            $id_empresa = auth('g_administradores')->user()->id_empresa;
        }

        $fecha_inicio = Carbon::parse($request->input('fecha_inicio'));
        $fecha_fin = Carbon::parse($request->input('fecha_fin'));
        $sedes = Sedes::select('sedes.direccion', 'sedes.correo', 'sedes.telefono', 'sedes.id_sede', 'sedes.nombre', 'zonas_horarias.zona_horaria')
            ->leftJoin('zonas_horarias', 'zonas_horarias.id_zona_horaria', '=', 'sedes.id_zona_horaria')
            ->where('sedes.id_empresa', $id_empresa)
            ->where('sedes.activo', 1)
            ->get();

        $novedades = TipoPermiso::where('id_empresa', $id_empresa)
            ->where('activo', 1)
            ->get();

        $id_empresa = $id_empresa;
        $id_empleado = $request->input('empleado');
        $nombre_empleado = Empleados::where('id_empleado', $id_empleado)->first();
        $fecha_inicio = Carbon::parse($request->input('fecha_inicio'));
        $intervalo = $fecha_fin->diff($fecha_inicio);
        $metodo = $request->input('accion');

        if (isset(auth('g_usuarios')->user()->id_empleado)) {
            if ($metodo == 'Nuevo') {
                return view('usuarios.asignar-horario', compact('id_empresa', 'id_empleado', 'fecha_inicio', 'intervalo', 'nombre_empleado', 'sedes', 'novedades'));
            } else {
                $horarios = Horarios::where('id_empleado', $id_empleado)
                    ->whereBetween('fecha_h', [$fecha_inicio, $fecha_fin])
                    ->get();

                $intervalo = Horarios::where('id_empleado', $id_empleado)
                    ->whereBetween('fecha_h', [$fecha_inicio, $fecha_fin])
                    ->count();

                return view('usuarios.editar-horario', compact('horarios', 'id_empresa', 'id_empleado', 'fecha_inicio', 'intervalo', 'nombre_empleado', 'sedes', 'novedades'));
            }
        } else {
            if ($metodo == 'Nuevo') {
                return view('admin.asignar-horario', compact('id_empresa', 'id_empleado', 'fecha_inicio', 'intervalo', 'nombre_empleado', 'sedes', 'novedades'));
            } else {
                $horarios = Horarios::where('id_empleado', $id_empleado)
                    ->whereBetween('fecha_h', [$fecha_inicio, $fecha_fin])
                    ->get();

                $intervalo = Horarios::where('id_empleado', $id_empleado)
                    ->whereBetween('fecha_h', [$fecha_inicio, $fecha_fin])
                    ->count();

                return view('admin.editar-horario', compact('horarios', 'id_empresa', 'id_empleado', 'fecha_inicio', 'intervalo', 'nombre_empleado', 'sedes', 'novedades'));
            }
        }
    }

    public function crear(Request $request)
    {
        if (isset(auth('g_usuarios')->user()->id_empleado)) {
            $id_empleado2 = auth('g_usuarios')->user()->id_empleado;
            $id_empresa = auth('g_usuarios')->user()->empleado->administradores->id_empresa;
        }
        if (isset(auth('g_administradores')->user()->id_empresa)) {
            $id_empleado2 = null;
            $id_empresa = auth('g_administradores')->user()->id_empresa;
        }

        $errores = [];
        // dd($request->input('fecha0'));
        for ($i = 0; $i <= $request->input('intervalo'); $i++) {

            $horario = Horarios::where('id_empleado', $request->input('id_empleado'))
                ->where('fecha_h', $request->input('fecha' . $i))
                ->first();


            if ($horario != null) {
                $errores[] = 'Ya existe un horario en esta fecha: ' . Carbon::parse($request->input('fecha' . $i))->format('Y-m-d');
                continue;
            }

            $nuevoHorario = new Horarios();
            $nuevoHorario->id_empresa = $id_empresa;
            $nuevoHorario->id_empleado = $request->input('id_empleado');
            $nuevoHorario->fecha_h = $request->input('fecha' . $i);
            $nuevoHorario->entrada_h = $request->input('entrada' . $i);
            $nuevoHorario->salida_h = $request->input('salida' . $i);
            $nuevoHorario->tiempo_fuera = $request->input('lunch' . $i);
            $nuevoHorario->id_sede = $request->input('sede' . $i);
            //$nuevoHorario->total = $request->input('total' . $i) == null ? 0 : $request->input('total' . $i);
            $nuevoHorario->id_permiso = $request->input('novedad' . $i);
            $nuevoHorario->creado_por = $id_empleado2;
            $nuevoHorario->save();
        }

        if ($errores) {
            Session::flash('errores', $errores);
        }

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente');
    }

    public function actualizar(Request $request)
    {
        if (isset(auth('g_usuarios')->user()->id_empleado)) {
            $id_empleado2 = auth('g_usuarios')->user()->id_empleado;
        }
        if (isset(auth('g_administradores')->user()->id_empresa)) {
            $id_empleado2 = null;
        }

        for ($i = 0; $i <= $request->input('intervalo') - 1; $i++) {

            $horario = Horarios::where('id_empleado', $request->input('id_empleado'))
                ->where('fecha_h', $request->input('fecha' . $i))
                ->first();

            $horario->entrada_h = $request->input('entrada' . $i);
            $horario->salida_h = $request->input('salida' . $i);
            $horario->tiempo_fuera = $request->input('lunch' . $i);
            $horario->id_sede = $request->input('sede' . $i);
            $horario->id_permiso = $request->input('novedad' . $i);
            $horario->actualizado_por = $id_empleado2;
            $horario->save();
        }

        return redirect()->route('horarios.index')->with('success', 'Horario editado correctamente');
    }

    public function edit($id_horario)
    {

        $sedes = Sedes::select('sedes.direccion', 'sedes.correo', 'sedes.telefono', 'sedes.id_sede', 'sedes.nombre', 'zonas_horarias.zona_horaria')
            ->leftJoin('zonas_horarias', 'zonas_horarias.id_zona_horaria', '=', 'sedes.id_zona_horaria')
            ->where('sedes.id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)
            ->where('sedes.activo', 1)
            ->get();

        $novedades = TipoPermiso::where('id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)
            ->where('activo', 1)
            ->get();

        $horario = Horarios::where('id_horario', $id_horario)->first();
        $nombre_empleado = Empleados::where('id_empleado', $horario->id_empleado)->first();

        return view('usuarios.editar-horario', compact('horario', 'sedes', 'novedades', 'nombre_empleado'));
    }

    public function update(Request $request, $id_horario)
    {
        $horario = Horarios::where('id_horario', $id_horario)->first();
        $i = 0;

        $horario->entrada_h = $request->input('entrada' . $i);
        $horario->salida_h = $request->input('salida' . $i);
        $horario->tiempo_fuera = $request->input('lunch' . $i);
        $horario->id_sede = $request->input('sede' . $i);
        //$horario->total = $request->input('total' . $i) == null ? 0 : $request->input('total' . $i);
        $horario->id_permiso = $request->input('novedad' . $i);
        $horario->actualizado_por = auth('g_usuarios')->user()->empleado->id_empleado;
        $horario->save();


        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente');
    }

    public function delete($id_horario)
    {
        $horario = Horarios::where('id_horario', $id_horario)->first();

        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente');
    }
}
