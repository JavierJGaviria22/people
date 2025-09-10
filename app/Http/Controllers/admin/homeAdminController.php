<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Noticias;
use App\Models\Empresas;
use App\Models\InfoEmpleados;

class homeAdminController extends Controller
{
    public function index()
    {
        $configurada = Empresas::where('id_empresa',auth('g_administradores')->user()->id_empresa)->first()->configurada;
         //dd($configurada);

        $noticias = Noticias::whereRaw('? BETWEEN noticias.fecha_inicio AND noticias.fecha_fin', [today()])
            ->where('id_empresa', auth('g_administradores')->user()->id_empresa) // Suponiendo que tienes el ID del empleado
            ->select('noticias.*') // Selecciona las columnas que necesitas de la tabla noticias
            ->get();

        $cumpleaños = InfoEmpleados::whereRaw('MONTH(fecha_nacimiento) = MONTH(CURDATE())')
            ->where('id_empresa',  auth('g_administradores')->user()->id_empresa)
            ->get();

        $empleadosActivos = InfoEmpleados::where('id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('activo', 'Si')
            ->count();
        $empleadostotal = InfoEmpleados::where('id_empresa', auth('g_administradores')->user()->id_empresa)->count();

        $vacacionesMes = DB::table('permisos as p')
            ->join('empleados as e', 'e.id_empleado', '=', 'p.id_empleado')
            ->join('tipo_permiso as tp', 'tp.id_tipo_permiso', '=', 'p.id_tipo_permiso')
            ->whereMonth('p.fecha_inicio', now()->month)
            ->whereYear('p.fecha_inicio', now()->year)
            ->where('p.aprobado', 1)
            ->where('e.id_empresa', auth('g_administradores')->user()->id_empresa)
            ->where('tp.tipo', 'PTO')
            ->count();

        $contratosPorVencer = DB::table('contratos as c')
            ->join('empleados as e', 'e.id_empleado', '=', 'c.id_empleado')
            ->whereMonth('c.fecha_fin', now()->month)
            ->whereYear('c.fecha_fin', now()->year)
            ->where('c.activo', 1)
            ->where('e.id_empresa',  auth('g_administradores')->user()->id_empresa)
            ->count();

        return view(
            'admin.inicio',
            compact('cumpleaños', 'noticias', 'empleadosActivos', 'empleadostotal', 'vacacionesMes', 'contratosPorVencer','configurada')
        );
    }

    public function contratos()
    {
        $contratosPorVencer = DB::table('contratos as c')
            ->join('empleados as e', 'e.id_empleado', '=', 'c.id_empleado')
            ->join('tipo_contrato as tc', 'tc.id_tipo_contrato', '=', 'c.id_tipo_contrato')
            ->whereMonth('c.fecha_fin', now()->month)
            ->whereYear('c.fecha_fin', now()->year)
            ->where('c.activo', 1)
            ->where('e.id_empresa', 1)
            ->select('c.*', 'tc.nombre as tipo_contrato', 'e.*')
            ->get();
        return view('admin.contratos-por-vencer', compact('contratosPorVencer'));
    }
}
