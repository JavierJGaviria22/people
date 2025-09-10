<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Departamentos;
use App\Models\Empleados;
use App\Models\Noticias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class departamentosAdminController extends Controller
{
    public function index()
    {
        //Mostrar todas los departamentos
        $departamentos = Departamentos::select(
            'departamentos.nombre AS departamento', 'departamentos.id_departamento',
            DB::raw("CONCAT(empleados.nombre, ' ', empleados.apellido) AS lider")
        )
            ->leftjoin('empleados', 'empleados.id_empleado', '=', 'departamentos.lider')
            ->where('departamentos.id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('departamentos.activo', 1)
            ->get();

        return view('admin.departamentos', compact('departamentos'));
    }

    public function create()
    {
        // Mostrar el formulario para crear nuevo departamento
        return view('admin.nuevo-departamento');
    }

    public function store(Request $request)
    {
        // Agregar un nuevo departamento

        $request->validate([
            'nombre' => 'required',

        ], [
            'nombre.required' => 'Nombre requerido',
        ]);

        $count = Departamentos::where('id_empresa', auth('g_administradores')->user()->id_empresa)
        ->where('nombre', $request->input('nombre'))
        ->where('activo', 1)
        ->count();

        if ($count>=1) {
            return redirect()->route('departamentos.create')->with('error', 'Este departamento ya existe');
        }
        
        $nuevaDepartamento = new Departamentos();
        $nuevaDepartamento->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevaDepartamento->nombre = $request->input('nombre');
        $nuevaDepartamento->fecha_creacion = now();
        $nuevaDepartamento->creado_por = auth('g_administradores')->user()->id_admin;
        $nuevaDepartamento->save();

        return redirect()->route('departamentos.create')->with('success', 'Departamento creado correctamente');
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
        // Agregar un nuevo departamento
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

    //show es el metodo para desactivar la noticia ¡importante!
    public function show($id_departamento)
    {
        $departamento = Departamentos::where('id_departamento', $id_departamento)->first();

        if (!$departamento) {
            return redirect()->route('departamentos.index')->with('error', 'Departamento no encontrado.');
        }

        $departamento->activo = 0;
        $departamento->save();

        return redirect()->route('departamentos.index')->with('success', 'Departamento Eliminado correctamente.');
    }
}
