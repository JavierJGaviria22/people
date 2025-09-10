<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Departamentos;
use App\Models\Empleados;
use App\Models\Configuracion;
use App\Models\InfoEmpleados;
use App\Models\InfoPermisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class vacacionesAdminController extends Controller
{
    public function index()
    {
        $configuracion = Configuracion::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 1)
            ->get();

        return view('admin.vacaciones', compact('configuracion'));
    }

    public function create()
    {
        return view('admin.nuevo-vacaciones');
    }

    public function store(Request $request)
    {
        $obtencionPermitidos = ['antiguedad', 'asistencia'];
        $prorrogaPermitidos = ['Acumulables', 'No Acumulables'];

        $request->validate([
            'por' => 'required|numeric',
            'gano' => 'required|numeric',
            'renovacion' => 'nullable',
            'prueba' => 'required|numeric',
            'maxsaldo' => 'required|numeric',
            'desde' => 'required|integer',
            'hasta' => 'required|integer',
            'obtencion' => ['required', 'in:' . implode(',', $obtencionPermitidos)],
            'prorroga' => ['required', 'in:' . implode(',', $prorrogaPermitidos)]

        ], [
            'obtencion.required' => 'El modelo de obtencion de pto es requerido',
        ]);

        if ($request->input('desde') > $request->input('hasta')) {
            return redirect()->route('vacaciones.create')->with('error', 'El limite inferior es mayor al limite superior');
        }

        $registros = Configuracion::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 1)
            ->get();

        $listasFinales = [];

        foreach ($registros as $registro) {

            $desde = (int)$registro->aplicar_desde_años;
            $hasta = (int)$registro->aplicar_hasta_años;

            // Generar el rango de números entre 'desde' y 'hasta'
            $rango = range($desde, $hasta);

            // Unir la lista generada con la lista final
            $listasFinales = array_merge($listasFinales, $rango);
        }

        $limiteInferior = $request->input('desde');
        $limiteSuperior = $request->input('hasta');

        $listaDeNumeros = range($limiteInferior, $limiteSuperior);

        $interseccion = array_intersect($listasFinales, $listaDeNumeros);

        if (!empty($interseccion)) {
            return redirect()->route('vacaciones.create')->with('error', 'Error en los rangos de aplicación');
        }

        $nuevaConfiguracion = new Configuracion();
        $nuevaConfiguracion->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevaConfiguracion->metodo = $request->input('obtencion');
        $nuevaConfiguracion->formato = ($request->input('obtencion') == 'antiguedad') ? 'dias' : 'horas';
        $nuevaConfiguracion->por_esto = $request->input('por');
        $nuevaConfiguracion->obtencion = $request->input('gano');
        if ($request->filled('renovacion')) {
            $nuevaConfiguracion->renovacion = $request->input('renovacion');
        }
        $nuevaConfiguracion->usables_apartir_de = $request->input('prueba');
        $nuevaConfiguracion->max_saldo = $request->input('maxsaldo');
        $nuevaConfiguracion->aplicar_desde_años = $request->input('desde');
        $nuevaConfiguracion->aplicar_hasta_años = $request->input('hasta');
        $nuevaConfiguracion->fecha_creacion = now();
        $nuevaConfiguracion->creado_por = auth('g_administradores')->user()->id_admin;
        $nuevaConfiguracion->save();

        return redirect()->route('vacaciones.create')->with('success', 'Configuración agregada correctamente');
    }

    public function edit($id_config)
    {
        $config = Configuracion::where('id_configuracion', $id_config)->first();

        if (!$config) {
            return redirect()->route('vacaciones.index');
        }

        return view('admin.editar-vacaciones', compact('config'));
    }

    public function update(Request $request, $id_config)
    {
        // dd($request->input('renovacion'));
        $obtencionPermitidos = ['antiguedad', 'asistencia'];
        $prorrogaPermitidos = ['Acumulables', 'No Acumulables'];

        $request->validate([
            'por' => 'required|numeric',
            'gano' => 'required|numeric',
            'renovacion' => 'nullable',
            'prueba' => 'required|numeric',
            'maxsaldo' => 'required|numeric',
            'desde' => 'required|integer',
            'hasta' => 'required|integer',
            'obtencion' => ['required', 'in:' . implode(',', $obtencionPermitidos)],
            'prorroga' => ['required', 'in:' . implode(',', $prorrogaPermitidos)]

        ], [
            'obtencion.required' => 'El modelo de obtencion de pto es requerido',
        ]);

        if ($request->input('desde') > $request->input('hasta')) {
            return redirect()->route('vacaciones.edit')->with('error', 'El limite inferior es mayor al limite superior');
        }

        $registros = Configuracion::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 1)
            ->wherenot('id_configuracion', $id_config)
            ->get();

        $listasFinales = [];

        foreach ($registros as $registro) {

            $desde = (int)$registro->aplicar_desde_años;
            $hasta = (int)$registro->aplicar_hasta_años;

            // Generar el rango de números entre 'desde' y 'hasta'
            $rango = range($desde, $hasta);

            // Unir la lista generada con la lista final
            $listasFinales = array_merge($listasFinales, $rango);
        }

        $limiteInferior = $request->input('desde');
        $limiteSuperior = $request->input('hasta');

        $listaDeNumeros = range($limiteInferior, $limiteSuperior);

        $interseccion = array_intersect($listasFinales, $listaDeNumeros);

        if (!empty($interseccion)) {
            return redirect()->route('vacaciones.edit')->with('error', 'Error en los rangos de aplicación');
        }

        $configupdate = Configuracion::where('id_configuracion', $id_config)->first();

        $configupdate->id_empresa = auth('g_administradores')->user()->id_empresa;
        $configupdate->metodo = $request->input('obtencion');
        $configupdate->formato = ($request->input('obtencion') == 'antiguedad') ? 'dias' : 'horas';
        $configupdate->por_esto = $request->input('por');
        $configupdate->obtencion = $request->input('gano');
        if ($request->filled('renovacion')) {
            $configupdate->renovacion = $request->input('renovacion');
        } else $configupdate->renovacion = null;
        $configupdate->usables_apartir_de = $request->input('prueba');
        $configupdate->max_saldo = $request->input('maxsaldo');
        $configupdate->aplicar_desde_años = $request->input('desde');
        $configupdate->aplicar_hasta_años = $request->input('hasta');
        $configupdate->fecha_actualizacion = now();
        $configupdate->actualizado_por = auth('g_administradores')->user()->id_admin;
        $configupdate->save();

        return redirect()->route('vacaciones.edit', $id_config)->with('success', 'Configuración actualizada correctamente');
    }

    //show es el metodo para desactivar ¡importante!
    public function show($id_config)
    {
        $config = Configuracion::where('id_configuracion', $id_config)->first();

        if (!$config) {
            return redirect()->route('vacaciones.index')->with('error', 'Configuración no encontrado.');
        }

        $config->activo = 0;
        $config->save();

        return redirect()->route('vacaciones.index')->with('success', 'Configuracion Eliminada correctamente.');
    }
    
    public function showReporte()
    {
        $pto = InfoEmpleados::all();
        return view('admin.infor-pto', compact('pto'));
    }

    public function showpto($id_empleado)
    {
        $vistapto = InfoPermisos::where('tipo', 'PTO')->
        where('id_empleado', $id_empleado)
        ->get();
        $nombre_empleado = InfoEmpleados::where('id_empleado', $id_empleado)->first();
        return view('admin.vista-pto', compact('vistapto', 'nombre_empleado'));
    }
}
