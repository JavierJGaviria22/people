<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InfoEmpleados;

class calendarioController extends Controller
{
    public function index()
    {
        $events = DB::table('pd_horarios as h')
            ->select(DB::raw("'Entrada' as title, IFNULL(CONCAT(h.fecha_h, 'T', h.entrada_h), h.fecha_h) as start"))
            ->where('h.id_empleado', auth('g_usuarios')->user()->id_empleado)
            ->whereNull('h.id_permiso')
            ->union(
                DB::table('pd_horarios as h')
                    ->join('sedes as s', 's.id_sede', '=', 'h.id_sede')
                    ->select(DB::raw("CONCAT('* ', s.nombre) as title, h.fecha_h as start"))
                    ->where('h.id_empleado', auth('g_usuarios')->user()->id_empleado)
                    ->whereNull('h.id_permiso')
            )
            ->union(
                DB::table('pd_horarios as h')
                    ->select(DB::raw("'Salida' as title, IFNULL(CONCAT(h.fecha_h, 'T', h.salida_h), h.fecha_h) as start"))
                    ->where('h.id_empleado', auth('g_usuarios')->user()->id_empleado)
                    ->whereNull('h.id_permiso')
            )
            ->union(
                DB::table('pd_horarios as h')
                    ->leftjoin('tipo_permiso as s', 's.id_tipo_permiso', '=', 'h.id_permiso')
                    ->select(DB::raw("s.permiso as title, h.fecha_h as start"))
                    ->where('h.id_empleado', auth('g_usuarios')->user()->id_empleado)
                    ->whereNotNull('h.id_permiso')
            )
            ->union(
                DB::table('pd_horarios as h')
                    ->select(DB::raw("CONCAT('Lunch - ', h.tiempo_fuera) as title, h.fecha_h as start"))
                    ->where('h.id_empleado', auth('g_usuarios')->user()->id_empleado)
                    ->whereNull('h.id_permiso')
            )
            ->union(
                DB::table('pd_horarios as h')
                    ->select(DB::raw("CONCAT('Total horas = ', h.total) as title, h.fecha_h as start"))
                    ->where('h.id_empleado', auth('g_usuarios')->user()->id_empleado)
                    //->whereNull('h.id_permiso')
            )
            ->get();

        $eventsJson = $events->toJson();

        return view('usuarios.calendario-horarios', compact('eventsJson'));
    }
}
