<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Noticias;
use PHPUnit\Framework\Error\Notice;

class noticiasAdminController extends Controller
{
    public function index()
    {
        // Mostrar todas las noticias
        $noticias = Noticias::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 1)
            ->get();
        return view('admin.noticias', compact('noticias'));
    }

    public function create()
    {
        // Mostrar el formulario para crear una nueva noticia
        return view('admin.nueva-noticia');
    }

    public function store(Request $request)
    {
        // Agregar un nueva noticia

        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'fecha_inicio' => 'required|date|after_or_equal:today|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ], [
            'titulo.required' => 'La identificación es requerida',
            'contenido.required' => 'El nombre es requerido',
            'fecha_inicio.required' => 'El apellido es requerido',
            'fecha_fin.required' => 'La fecha de nacimiento es requerida',
        ]);

        $nuevaNoticia = new Noticias();
        $nuevaNoticia->titulo = $request->input('titulo');
        $nuevaNoticia->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevaNoticia->contenido = $request->input('contenido');
        $nuevaNoticia->fecha_inicio = $request->input('fecha_inicio');
        $nuevaNoticia->fecha_fin = $request->input('fecha_fin');
        $nuevaNoticia->fecha_creacion = now();
        $nuevaNoticia->creado_por = auth('g_administradores')->user()->id_admin;
        $nuevaNoticia->save();

        return redirect()->route('noticias.create')->with('success', 'Noticia creada correctamente');
    }

    public function edit($id_noticia)
    {
        // Mostrar el formulario para editar una noticia
        $noticia = Noticias::where('id_noticia', $id_noticia)->first();

        // Verificar si la noticia fue encontrada
        if (!$noticia) {
            return redirect()->route('noticias.index');
        }

        return view('admin.editar-noticia', compact('noticia'));
    }

    public function update(Request $request, $id_noticia)
    {
        // Actualizar la noticia
        // Recuperar la noticia correspondiente al id_noticia
        $noticia = Noticias::where('id_noticia', $id_noticia)->first();

        if (!$noticia) {
            return redirect()->route('noticias.index')->with('error', 'Noticia no encontrada.');
        }

        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'fecha_inicio' => 'required|date|after_or_equal:today|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ], [
            'titulo.required' => 'La identificación es requerida',
            'contenido.required' => 'El nombre es requerido',
            'fecha_inicio.required' => 'El apellido es requerido',
            'fecha_fin.required' => 'La fecha de nacimiento es requerida',
        ]);

        $noticia->titulo = $request->input('titulo');
        $noticia->id_empresa = auth('g_administradores')->user()->id_empresa;
        $noticia->contenido = $request->input('contenido');
        $noticia->fecha_inicio = $request->input('fecha_inicio');
        $noticia->fecha_fin = $request->input('fecha_fin');
        $noticia->fecha_actualizacion = now();
        $noticia->actualizado_por = auth('g_administradores')->user()->id_admin;
        $noticia->save();

        return redirect()->route('noticias.edit', $noticia->id_noticia)->with('success', 'Noticia actualizada correctamente.');
    }

    //show es el metodo para desactivar la noticia ¡importante!
    public function show($id_noticia)
    {
        // Eliminar o desactivar una noticia
        $noticia = Noticias::where('id_noticia', $id_noticia)->first();

        // Verificar si la noticia fue encontrado
        if (!$noticia) {
            return redirect()->route('noticias.index')->with('error', 'Noticia no encontrada.');
        }

        $noticia->activo = 0;
        $noticia->save();

        return redirect()->route('noticias.index')->with('success', 'Noticia Eliminada correctamente.');
    }
}
