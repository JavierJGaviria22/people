<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoContrato;
use Illuminate\Support\Facades\DB;

class tipoContratoAdminController extends Controller
{
    public function index()
    {
        $tipoContratos = TipoContrato::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 1)
            ->get();

        return view('admin.tipo-contratos', compact('tipoContratos'));
    }

    public function create()
    {
        return view('admin.nuevo-tipo-contrato');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ], [
            'nombre.required' => 'Nombre requerido',
        ]);

        $nuevoTipo = new TipoContrato();
        $nuevoTipo->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevoTipo->nombre = $request->input('nombre');
        $nuevoTipo->fecha_creacion = now();
        $nuevoTipo->creado_por = auth('g_administradores')->user()->id_admin;
        $nuevoTipo->save();

        return redirect()->route('tipo-contratos.create')->with('success', 'Tipo de contrato creado correctamente');
    }

    public function edit($id_tipo_contrato)
    {
        $tipo = TipoContrato::where('id_tipo_contrato', $id_tipo_contrato)->first();

        if (!$tipo) {
            return redirect()->route('tipo-contratos.index');
        }

        return view('admin.editar-tipo-contrato', compact('tipo'));
    }

    public function update(Request $request, $id_tipo_contrato)
    {
        $tipo = TipoContrato::where('id_tipo_contrato', $id_tipo_contrato)->first();

        $request->validate([
            'nombre' => 'required',
        ], [
            'nombre.required' => 'Nombre requerido',
        ]);

        $count = TipoContrato::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('nombre', $request->input('nombre'))
            ->where('activo', 1)
            ->whereNot('id_tipo_contrato', $id_tipo_contrato)
            ->count();

        if ($count >= 1) {
            return redirect()->route('tipo-contratos.edit', $id_tipo_contrato)->with('error', 'Este tipo de contrato ya existe');
        }

        $tipo->nombre = $request->input('nombre');
        $tipo->fecha_actualizacion = now();
        $tipo->actualizado_por = auth('g_administradores')->user()->id_admin;
        $tipo->save();

        return redirect()->route('tipo-contratos.edit', $tipo->id_tipo_contrato)->with('success', 'Tipo de contrato actualizado correctamente');
    }

    //show es el metodo para desactivar la noticia ¡importante!
    public function show($id_tipo_contrato)
    {
        $tipo = TipoContrato::where('id_tipo_contrato', $id_tipo_contrato)->first();

        $tipo->activo = 0;
        $tipo->fecha_actualizacion = now();
        $tipo->actualizado_por = auth('g_administradores')->user()->id_admin;
        $tipo->save();

        return redirect()->route('tipo-contratos.index', $id_tipo_contrato)->with('success', 'Tipo de contrato eliminado correctamente');
    }
}
