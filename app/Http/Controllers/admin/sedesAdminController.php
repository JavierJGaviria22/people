<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZonasHorarias;
use App\Models\Sedes;
use Illuminate\Support\Facades\DB;

class sedesAdminController extends Controller
{
    public function index()
    {
        $sedes = Sedes::select('sedes.direccion','sedes.correo','sedes.telefono','sedes.id_sede', 'sedes.nombre', 'zonas_horarias.zona_horaria')
            ->leftJoin('zonas_horarias', 'zonas_horarias.id_zona_horaria', '=', 'sedes.id_zona_horaria')
            ->where('sedes.id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('sedes.activo', 1)
            ->get();

        return view('admin.sedes', compact('sedes'));
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
}
