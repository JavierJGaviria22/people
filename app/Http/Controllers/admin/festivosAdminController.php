<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Festivos;
use App\Models\Empleados;
use App\Models\Noticias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class festivosAdminController extends Controller
{
    public function index()
    {
        $festivos = Festivos::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->get();

        return view('admin.festivos', compact('festivos'));
    }

    public function create()
    {
        return view('admin.nuevo-festivo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'fecha' => [
                'required',
                'date'
            ]
        ], [
            'fecha.required' => 'El campo Nombre es obligatorio.',
            'fecha.date' => 'El formato de Fecha es incorrecto',
        ]);

        $nuevoFestivo = new Festivos();
        $nuevoFestivo->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevoFestivo->nombre = $request->input('nombre');
        $nuevoFestivo->fecha = $request->input('fecha');
        $nuevoFestivo->save();

        return redirect()->route('festivos.create')->with('success', 'Festivo agregado correctamente');
    }

    public function edit($id_departamento)
    {
        $departamento = Departamentos::where('id_departamento', $id_departamento)->first();
        $empleados = Empleados::where('id_empresa', auth('g_administradores')->user()->id_empresa)
        ->where('id_departamento',$departamento->id_departamento)
        ->get();
        
        if (!$departamento) {
            return redirect()->route('departamento.index');
        }

        return view('admin.editar-departamento', compact('departamento','empleados'));
    }

    public function update(Request $request, $id_departamento)
    {
        $departamento = Departamentos::where('id_departamento', $id_departamento)->first();

        $empleadosValidos = Empleados::where('id_empresa', auth('g_administradores')->user()->id_empresa)
        ->where('id_departamento',$id_departamento)
        ->pluck('id_empleado')->toArray();
        
        $request->validate([
            'nombre' => 'required',
            'empleado' => ['required', 'in:' . implode(',', $empleadosValidos)],

        ], [
            'nombre.required' => 'Nombre requerido',
            'empleado.in' => 'Empleado no permitido',
        ]);

        $count = Departamentos::where('id_empresa', auth('g_administradores')->user()->id_empresa)
        ->where('nombre', $request->input('nombre'))
        ->where('activo', 1)
        ->whereNOT('id_departamento', $id_departamento)
        ->count();

        if ($count>=1) {
            return redirect()->route('departamentos.edit' , $id_departamento)->with('error', 'Este departamento ya existe');
        }

        $departamento->nombre = $request->input('nombre');
        $departamento->lider = $request->input('empleado');
        $departamento->fecha_actualizacion = now();
        $departamento->actualizado_por = auth('g_administradores')->user()->id_admin;
        $departamento->save();

        return redirect()->route('departamentos.edit', $id_departamento)->with('success', 'Departamento actualizado correctamente.');
    }

    //show es el metodo para desactivar el festivo ¡importante!
    public function show($id_festivo)
    {
        
        $festivo = Festivos::where('id_festivo', $id_festivo)->first();

        
        if (!$festivo) {
            return redirect()->route('festivos.index')->with('error', 'Festivo no encontrado.');
        }

        $festivo->delete();

        return redirect()->route('festivos.index')->with('success', 'Festivo Eliminado correctamente.');
    }
}
