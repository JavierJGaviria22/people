<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoContrato;
use App\Models\Empleados;
use App\Models\Contratos;
use Illuminate\Support\Facades\DB;

class contratosAdminController extends Controller
{
    public function index()
    {
        // Mostrar todos los contratos
        $contratos = DB::table('contratos as c')
            ->join('empleados as e', 'e.id_empleado', '=', 'c.id_empleado')
            ->join('tipo_contrato as tc', 'tc.id_tipo_contrato', '=', 'c.id_tipo_contrato')
            ->select(
                'c.id_contrato',
                DB::raw("CONCAT(e.nombre, ' ', e.apellido) AS empleado"),
                'tc.nombre AS tipo',
                'c.cargo',
                'c.salario'
            )
            ->where('e.id_empresa',  auth('g_administradores')->user()->id_empresa)
            ->where('c.activo', 1)
            ->get();

        return view('admin.contratos', compact('contratos'));
    }

    public function create()
    {
        // Mostrar el formulario para crear uno nuevo Contrato
        $tipoContratos = TipoContrato::where('id_empresa', auth('g_administradores')->user()->id_empresa)->get();
        $empleados = Empleados::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 1)
            ->get();
        return view('admin.nuevo-contrato', compact('tipoContratos', 'empleados'));
    }

    public function store(Request $request)
    {
        
        $empleadosPermitidos = Empleados::where('id_empresa', auth('g_administradores')->user()->id_empresa)->pluck('id_empleado')->toArray();
        $tiposPermitidos = TipoContrato::where('id_empresa', auth('g_administradores')->user()->id_empresa)->pluck('id_tipo_contrato')->toArray();
        
        $request->validate([
            'empleado' => ['required', 'in:' . implode(',', $empleadosPermitidos)],
            'tipo_contrato' => ['required', 'in:' . implode(',', $tiposPermitidos)],
            'cargo' => 'required',
            'funciones' => 'required',
            'salario' => 'required|numeric',
            'fecha_inicio' => 'required|date|after_or_equal:today|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ], [
            'titulo.required' => 'La identificación es requerida',
            'contenido.required' => 'El nombre es requerido',
            'fecha_inicio.required' => 'El apellido es requerido',
            'fecha_fin.required' => 'La fecha de nacimiento es requerida',
        ]);

        $diasLaborales = implode(',', $request->input('dias_laborales'));
        //dd($diasLaborales);

        // Si no hay errores, proceder con la inserción en la base de datos
        $nuevoContrato = new Contratos();
        $nuevoContrato->id_empleado = $request->input('empleado');
        $nuevoContrato->id_tipo_contrato = $request->input('tipo_contrato');
        $nuevoContrato->cargo = $request->input('cargo');
        $nuevoContrato->funciones = $request->input('funciones');
        $nuevoContrato->salario = $request->input('salario');
        $nuevoContrato->dias_laborales = $diasLaborales;
        $nuevoContrato->fecha_inicio = $request->input('fecha_inicio');
        $nuevoContrato->fecha_fin = $request->input('fecha_fin');
        //$nuevoContrato->fecha_creacion = now();
        //$nuevoContrato->creado_por = auth('g_administradores')->user()->id_admin;
        $nuevoContrato->save();

        return redirect()->route('contratos.create')->with('success', 'Contrato creado correctamente');
    }

    public function edit($id_contrato)
    {
        $tipoContratos = TipoContrato::where('id_empresa', auth('g_administradores')->user()->id_empresa)->get();
        $empleados = Empleados::where('id_empresa', auth('g_administradores')->user()->id_empresa)->get();
        $contrato = Contratos::where('id_contrato', $id_contrato)->first();
        $diasLaborales = explode(',', $contrato->dias_laborales);

        if (!$contrato) {
            return redirect()->route('contratos.index');
        }

        return view('admin.editar-contrato', compact('contrato','tipoContratos','empleados','diasLaborales'));
    }

    public function update(Request $request, $id_contrato)
    {
    $empleadosPermitidos = Empleados::where('id_empresa', auth('g_administradores')->user()->id_empresa)->pluck('id_empleado')->toArray();
    $tiposPermitidos = TipoContrato::where('id_empresa', auth('g_administradores')->user()->id_empresa)->pluck('id_tipo_contrato')->toArray();

    $request->validate([
        'empleado' => ['required', 'in:' . implode(',', $empleadosPermitidos)],
        'tipo_contrato' => ['required', 'in:' . implode(',', $tiposPermitidos)],
        'cargo' => 'required',
        'funciones' => 'required',
        'salario' => 'required|numeric',
        'fecha_inicio' => 'required|date|after_or_equal:today|before_or_equal:fecha_fin',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ], [
        'titulo.required' => 'La identificación es requerida',
        'contenido.required' => 'El nombre es requerido',
        'fecha_inicio.required' => 'La fecha de inicio es requerida',
        'fecha_fin.required' => 'La fecha de fin es requerida',
    ]);

    $contrato = Contratos::where('id_contrato', $id_contrato)->first();

    // Convertir los días laborales a un string
    $diasLaborales = implode(',', $request->input('dias_laborales', []));

    // Actualizar los campos del contrato
    $contrato->id_empleado = $request->input('empleado');
    $contrato->id_tipo_contrato = $request->input('tipo_contrato');
    $contrato->cargo = $request->input('cargo');
    $contrato->funciones = $request->input('funciones');
    $contrato->salario = $request->input('salario');
    $contrato->dias_laborales = $diasLaborales; // Actualizar los días laborales
    $contrato->fecha_inicio = $request->input('fecha_inicio');
    $contrato->fecha_fin = $request->input('fecha_fin');
    $contrato->save();

    return redirect()->route('contratos.edit' ,$contrato->id_contrato)->with('success', 'Contrato actualizado correctamente');
    }

    //show es el metodo para desactivar la noticia ¡importante!
    public function show($id_contrato)
    {
        $contrato = Contratos::where('id_contrato', $id_contrato)->first();

        if (!$id_contrato) {
            return redirect()->route('contratos.index')->with('error', 'Contrato no encontrado.');
        }

        $contrato->activo = 0;
        $contrato->save();

        return redirect()->route('contratos.index')->with('success', 'contrato Eliminado correctamente.');
    }
}
