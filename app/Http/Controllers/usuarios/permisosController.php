<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Permisos;
use App\Models\InfoEmpleados;
use App\Models\InfoPermisos;
use App\Models\TipoPermiso;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class permisosController extends Controller
{
    public function index()
    {
        $info_empleados = InfoEmpleados::where('id_empleado', auth('g_usuarios')->user()->id_empleado)->first();
        $info_permisos = InfoPermisos::where('lider', auth('g_usuarios')->user()->id_empleado)->get();
        if ($info_empleados && ($info_empleados->lider) !== null) {
            return view('usuarios.permisos', compact('info_permisos'));
        } else {
            return redirect('/');
        }
    }

    public function misPermisos()
    {
        //$info_empleados = InfoEmpleados::where('id_empleado', auth('g_usuarios')->user()->id_empleado)->first();
        $info_permisos = InfoPermisos::where('id_empleado', auth('g_usuarios')->user()->id_empleado)->get();
        return view('usuarios.mis-permisos', compact('info_permisos'));
    }

    public function nuevoPermiso()
    {
       /* $tiposPermiso = TipoPermiso::join('administradores', 'tipo_permiso.creado_por', '=', 'administradores.id_admin')
            ->where('administradores.id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)
            ->where('tipo', '=', 'Permiso')
            ->or ('tipo', '=', 'PTO')
            ->select('tipo_permiso.id_tipo_permiso', 'tipo_permiso.permiso')
            ->get();*/
            
             $tiposPermiso = TipoPermiso::join('administradores', 'tipo_permiso.creado_por', '=', 'administradores.id_admin')
    ->where('administradores.id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)
    ->where(function($query) {
        $query->where('tipo', '=', 'Permiso')
              ->orWhere('tipo', '=', 'PTO');
    })
    ->select('tipo_permiso.id_tipo_permiso', 'tipo_permiso.permiso')
    ->get();

        return view('usuarios.nuevo-permiso', compact('tiposPermiso'));
    }

    public function agregarPermiso(Request $request)
    {
        $diasNoPermitidos = DB::table('z_info_permisos')
            ->where('id_empleado', auth('g_usuarios')->user()->id_empleado)
            ->whereIn('estado', ['Aprobado', 'Pendiente'])
            ->select(DB::raw('DATE(fecha_inicio) as fecha_inicio'))  // Aquí se usa DATE() para extraer solo la fecha
            ->union(
                DB::table('z_info_permisos')
                    ->where('id_empleado', 2)
                    ->whereIn('estado', ['Aprobado', 'Pendiente'])
                    ->select(DB::raw('DATE(fecha_fin) as fecha_fin'))  // Lo mismo para fecha_fin
            )
            ->pluck('fecha_inicio')  // Pluck devuelve solo el valor de fecha_inicio
            ->toArray();
        // dd($request->fecha_inicio);
        $fechaInicio = \Carbon\Carbon::parse($request->input('fecha_inicio'))->format('Y-m-d');
        $fechaFin = \Carbon\Carbon::parse($request->input('fecha_fin'))->format('Y-m-d');

        $request->validate([
            'id_tipo_permiso' => 'required',
            'regresa' => 'required|numeric',
            'fecha_inicio' => [
                'required',
                'date'
            ],
            'fecha_fin' => [
                'required',
                'date'
            ],
        ], [
            'id_tipo_permiso.required' => 'El campo "Tipo de Permiso" es obligatorio.',
            'fecha_inicio.required' => 'El campo "Fecha de Inicio" es obligatorio.',
            'fecha_fin.required' => 'El campo "Fecha de Fin" es obligatorio.',
            'fecha_fin.after_or_equal' => 'La "Fecha de Fin" debe ser igual o posterior a la "Fecha de Inicio".',
        ]);

        $tipoPermisoSolicitado = TipoPermiso::where('id_tipo_permiso', $request->input('id_tipo_permiso'))->first();

        if ($tipoPermisoSolicitado->tipo == 'PTO') {
            $ptoDisponible = InfoEmpleados::where('id_empleado', auth('g_usuarios')->user()->id_empleado)->first();

            $fechaInicio = Carbon::parse($request->input('fecha_inicio'));
            $fechaFin = Carbon::parse($request->input('fecha_fin'));

            $ptoSolicitado = $fechaInicio->diffInHours($fechaFin);

            if ($ptoDisponible->vacaciones_disponibles < $ptoSolicitado) {
                return redirect()->route('nuevo-permiso')->with('error', 'PTO insuficiente.');
            }
        }

        $nuevoPermiso = new Permisos();
        $nuevoPermiso->id_empleado = auth('g_usuarios')->user()->empleado->id_empleado;
        $nuevoPermiso->id_tipo_permiso = $request->input('id_tipo_permiso');
        if ($request->input('regresa') == 1) {
            $nuevoPermiso->regresa = 1;
        } elseif ($request->input('regresa') == 0) {
            $nuevoPermiso->regresa = 0;
        }
        $nuevoPermiso->descripcion = $request->input('descripcion');
        $nuevoPermiso->fecha_solicitud = now();
        $nuevoPermiso->fecha_inicio = $request->input('fecha_inicio');
        $nuevoPermiso->fecha_fin = $request->input('fecha_fin');
        $nuevoPermiso->save();  // Guardar en la base de datos

        return redirect()->route('nuevo-permiso')->with('success', 'Permiso creado correctamente');
    }

    public function editarPermiso($id_permiso)
    {

        $permiso = Permisos::where('id_permiso', $id_permiso)->first();

        if (!$permiso || $permiso->id_empleado != auth('g_usuarios')->user()->empleado->id_empleado) {
            return redirect()->route('mis-permisos');
        }

        $tiposPermiso = TipoPermiso::join('administradores', 'tipo_permiso.creado_por', '=', 'administradores.id_admin')
            ->where('administradores.id_empresa', auth('g_usuarios')->user()->empleado->administradores->id_empresa)
            ->select('tipo_permiso.id_tipo_permiso', 'tipo_permiso.permiso')
            ->get();

        return view('usuarios.editar-permiso', compact('tiposPermiso', 'permiso'));
    }

    public function actualizarPermiso(Request $request, $id_permiso)
    {
        // Recuperar el permiso correspondiente al id_permiso
        $permiso = Permisos::where('id_permiso', $id_permiso)->first();

        if (!$permiso) {
            return redirect()->route('mis-permisos')->with('error', 'Permiso no encontrado.');
        }

        $request->validate([
            'id_tipo_permiso' => 'required',
            'regresa' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio', // Asegura que la fecha fin sea posterior o igual a la fecha inicio
        ], [
            'id_tipo_permiso.required' => 'El campo "Tipo de Permiso" es obligatorio.',
            'fecha_inicio.required' => 'El campo "Fecha de Inicio" es obligatorio.',
            'fecha_fin.required' => 'El campo "Fecha de Fin" es obligatorio.',
            'fecha_fin.after_or_equal' => 'La "Fecha de Fin" debe ser igual o posterior a la "Fecha de Inicio".',
        ]);

        $permiso->id_tipo_permiso = $request->input('id_tipo_permiso');
        if ($request->input('regresa') == 1) {
            $permiso->regresa = 1;
        } elseif ($request->input('regresa') == 0) {
            $permiso->regresa = 0;
        }
        $permiso->descripcion = $request->input('descripcion');
        $permiso->fecha_inicio = $request->input('fecha_inicio');
        $permiso->fecha_fin = $request->input('fecha_fin');
        $permiso->save();
        //dd('Permiso actualizado');
        return redirect()->route('editar-permiso', $permiso->id_permiso)->with('success', 'Permiso actualizado correctamente.');
    }

    public function eliminarPermiso($id_permiso)
    {
        $permiso = Permisos::where('id_permiso', $id_permiso)->first();

        if (!$permiso) {
            return redirect()->route('mis-permisos')->with('error', 'Permiso no encontrado.');
        }

        $permiso->delete();

        return redirect()->route('mis-permisos')->with('success', 'Permiso eliminado con éxito.');
    }

    public function actuarPermiso(Request $request, $id_permiso)
    {
        $permiso = Permisos::find($id_permiso);

        if (!$permiso) {
            return response()->json([
                'success' => false,
                'message' => 'Permiso no encontrado.'
            ], 404); 
        }

        $accion = $request->input('accion');

        if ($accion === 'aprobar') {
            // Lógica para aprobar el permiso
            $permiso->aprobado = 1;
            $permiso->pendiente = 0;
            $permiso->declinado = 0;
            $permiso->remunerado = $request->input('remunerado', 0) ? 1 : 0;
        } elseif ($accion === 'declinar') {
            // Lógica para declinar el permiso
            $permiso->declinado = 1;
            $permiso->pendiente = 0;
            $permiso->aprobado = 0;
            $permiso->remunerado = 0;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Acción no válida.'
            ], 400);
        }

        $permiso->save();

        return response()->json([
            'success' => true,
            'message' => $accion === 'aprobar' ? 'Permiso aprobado con éxito.' : 'Permiso reprobado con éxito.'
        ]);
    }
}
