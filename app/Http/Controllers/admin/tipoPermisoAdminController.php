<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoPermiso;
use Illuminate\Support\Facades\DB;

class tipoPermisoAdminController extends Controller
{
    
    public function index()
    {
        
        $tipopermisos = TipoPermiso::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 1)
            ->get();

        return view('admin.tipo-permisos', compact('tipopermisos'));
    }

    public function create()
    {
        // Mostrar el formulario para crear

        return view('admin.nuevo-tipo-permiso');
    }

    public function store(Request $request)
    {
        $tiposPermitidos = ['Obligatorio', 'Personal','PTO'];

        $request->validate([
            'nombre' => 'required',
            'tipoPermiso' => ['required', 'in:' . implode(',', $tiposPermitidos)]
        ], [
            'nombre.required' => 'Nombre requerido',
            'tipoPermiso.in' => 'El Tipo de Permiso seleccionado es inválido'
        ]);

        $nuevoTipo = new TipoPermiso();
        $nuevoTipo->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevoTipo->permiso = $request->input('nombre');
        $nuevoTipo->tipo = $request->input('tipoPermiso');
        $nuevoTipo->fecha_creacion = now();
        $nuevoTipo->creado_por = auth('g_administradores')->user()->id_admin;
        $nuevoTipo->save();

        return redirect()->route('tipo-permisos.create')->with('success', 'Tipo de permiso creado correctamente');
    }

    public function edit($id_tipo_permiso)
    {
        $tipo = TipoPermiso::where('id_tipo_permiso', $id_tipo_permiso)->first();

        if (!$tipo) {
            return redirect()->route('tipo-permisos.index');
        }

        return view('admin.editar-tipo-permiso', compact('tipo'));
    }

    public function update(Request $request, $id_tipo_permiso)
    {
        $tipo = TipoPermiso::where('id_tipo_permiso', $id_tipo_permiso)->first();

        $request->validate([
            'nombre' => 'required',
        ], [
            'nombre.required' => 'Nombre requerido',
        ]);

        $count = TipoPermiso::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('permiso', $request->input('nombre'))
            ->where('activo', 1)
            ->whereNot('id_tipo_permiso', $id_tipo_permiso)
            ->count();

        if ($count >= 1) {
            return redirect()->route('tipo-permisos.edit', $id_tipo_permiso)->with('error', 'Este tipo de permiso ya existe');
        }

        $tipo->permiso = $request->input('nombre');
        $tipo->fecha_actualizacion = now();
        $tipo->actualizado_por = auth('g_administradores')->user()->id_admin;
        $tipo->save();

        return redirect()->route('tipo-permisos.edit', $tipo->id_tipo_permiso)->with('success', 'Tipo de permiso actualizado correctamente');
    }

    //show es el metodo para desactivar la noticia ¡importante!
    public function show($id_tipo_permiso)
    {
        $tipo = TipoPermiso::where('id_tipo_permiso', $id_tipo_permiso)->first();

        $tipo->activo = 0;
        $tipo->fecha_actualizacion = now();
        $tipo->actualizado_por = auth('g_administradores')->user()->id_admin;
        $tipo->save();

        return redirect()->route('tipo-permisos.index', $id_tipo_permiso)->with('success', 'Tipo de permiso eliminado correctamente');
    }
}
