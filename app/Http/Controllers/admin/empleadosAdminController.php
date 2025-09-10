<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Empleados;
use Illuminate\Http\Request;
use App\Models\Departamentos;
use App\Models\Sedes;
use App\Models\InfoEmpleados;

class empleadosAdminController extends Controller
{
    public function mostrar()
    {
        return view('admin.empleados');
    }

    public function nuevoEmpleado()
    {
        $selectDepartamentos = Departamentos::where('id_empresa', auth('g_administradores')->user()->id_empresa)->get();
        $selectSedes = Sedes::where('id_empresa', auth('g_administradores')->user()->id_empresa)->get();
        return view('admin.nuevo-empleado', compact('selectDepartamentos', 'selectSedes'));
    }

    public function agregarEmpleado(Request $request)
    {
        $generosPermitidos = ['Masculino', 'Femenino'];
        $estadoCivilPermitidos = ['Soltero', 'Casado', 'Divorciado', 'Viudo'];
        $dptosPermitidos = Departamentos::where('id_empresa', auth('g_administradores')->user()->id_empresa)->pluck('id_departamento')->toArray();
        $sedesPermitidos = Sedes::where('id_empresa', auth('g_administradores')->user()->id_empresa)->pluck('id_sede')->toArray();

        $request->validate([
            'cedula' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'nacimiento' => 'required|date',
            'genero' => ['required', 'in:' . implode(',', $generosPermitidos)],
            'email' => 'required|email',
            'ingreso' => 'required|date',
            'telefono' => 'required',
            'estado-civil' => ['required', 'in:' . implode(',', $estadoCivilPermitidos)],
            'nhijos' => 'required|integer|min:0',
            'dpto' => ['required', 'in:' . implode(',', $dptosPermitidos)],
            'sede' => ['required', 'in:' . implode(',', $sedesPermitidos)],
        ], [
            'cedula.required' => 'La identificación es requerida',
            'nombre.required' => 'El nombre es requerido',
            'apellido.required' => 'El apellido es requerido',
            'nacimiento.required' => 'La fecha de nacimiento es requerida',
            'genero.required' => 'El género es requerido',
            'genero.in' => 'El género seleccionado es inválido',
            'email.required' => 'El correo es requerido',
            'email.email' => 'El formato del correo es inválido',
            'ingreso.required' => 'La fecha de ingreso es requerida',
            'telefono.required' => 'El número de teléfono es requerido',
            'estado-civil.required' => 'El estado civil es requerido',
            'estado-civil.in' => 'El estado civil seleccionado es inválido',
            'nhijos.required' => 'El número de hijos es requerido',
            'nhijos.integer' => 'El número de hijos debe ser un número entero',
            'nhijos.min' => 'El número de hijos debe ser mayor o igual a 0',
            'dpto.required' => 'El departamento es requerido',
            'dpto.in' => 'El departamento seleccionado es inválido',
            'sede.required' => 'La sede es requerida',
            'sede.in' => 'La sede seleccionada es inválida',
        ]);

        $nuevoEmpleado = new Empleados();
        $nuevoEmpleado->id_empresa = auth('g_administradores')->user()->id_empresa;
        $nuevoEmpleado->cedula = $request->input('cedula');
        $nuevoEmpleado->nombre = $request->input('nombre');
        $nuevoEmpleado->apellido = $request->input('apellido');
        $nuevoEmpleado->fecha_nacimiento = $request->input('nacimiento');
        $nuevoEmpleado->genero = $request->input('genero');
        $nuevoEmpleado->correo = $request->input('email');
        $nuevoEmpleado->celular = $request->input('telefono');
        $nuevoEmpleado->estado_civil = $request->input('estado-civil');
        $nuevoEmpleado->nro_hijos = $request->input('nhijos');
        $nuevoEmpleado->id_departamento = $request->input('dpto');
        $nuevoEmpleado->id_sede = $request->input('sede');
        $nuevoEmpleado->fecha_entrada = $request->input('ingreso');
        $nuevoEmpleado->fecha_creacion = now();
        $nuevoEmpleado->creado_por = auth('g_administradores')->user()->id_admin;
        $nuevoEmpleado->save(); 

        return redirect()->route('nuevo-empleado')->with('success', 'Empleado creado correctamente');
    }

    public function editarEmpleado($id_empleado)
    {
        $empleado = InfoEmpleados::where('id_empleado', $id_empleado)->first();

        if (!$empleado) {
            return redirect()->route('mis-permisos');
        }

        $selectDepartamentos = Departamentos::where('id_empresa', auth('g_administradores')->user()->id_empresa)->get();
        $selectSedes = Sedes::where('id_empresa', auth('g_administradores')->user()->id_empresa)->get();

        return view('admin.editar-empleado', compact('selectDepartamentos', 'selectSedes', 'empleado'));
    }

    public function actualizarEmpleado(Request $request, $id_empleado)
    {
        // Recuperar el permiso correspondiente al id_permiso
        $empleado = Empleados::where('id_empleado', $id_empleado)->first();

        if (!$empleado) {
            return redirect()->route('empleados')->with('error', 'Empleado no encontrado.');
        }
        $generosPermitidos = ['Masculino', 'Femenino'];
        $estadoCivilPermitidos = ['Soltero', 'Casado', 'Divorciado', 'Viudo'];
        $dptosPermitidos = Departamentos::where('id_empresa', auth('g_administradores')->user()->id_empresa)->pluck('id_departamento')->toArray();
        $sedesPermitidos = Sedes::where('id_empresa', auth('g_administradores')->user()->id_empresa)->pluck('id_sede')->toArray();

        // Validar los datos
        $request->validate([
            'cedula' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'nacimiento' => 'required|date',
            'genero' => ['required', 'in:' . implode(',', $generosPermitidos)],
            'email' => 'required|email',
            'ingreso' => 'required|date',
            'telefono' => 'required',
            'estado-civil' => ['required', 'in:' . implode(',', $estadoCivilPermitidos)],
            'nhijos' => 'required|integer|min:0',
            'dpto' => ['required', 'in:' . implode(',', $dptosPermitidos)],
            'sede' => ['required', 'in:' . implode(',', $sedesPermitidos)],
        ], [
            'cedula.required' => 'La identificación es requerida',
            'nombre.required' => 'El nombre es requerido',
            'apellido.required' => 'El apellido es requerido',
            'nacimiento.required' => 'La fecha de nacimiento es requerida',
            'genero.required' => 'El género es requerido',
            'genero.in' => 'El género seleccionado es inválido',
            'email.required' => 'El correo es requerido',
            'email.email' => 'El formato del correo es inválido',
            'ingreso.required' => 'La fecha de ingreso es requerida',
            'telefono.required' => 'El número de teléfono es requerido',
            'estado-civil.required' => 'El estado civil es requerido',
            'estado-civil.in' => 'El estado civil seleccionado es inválido',
            'nhijos.required' => 'El número de hijos es requerido',
            'nhijos.integer' => 'El número de hijos debe ser un número entero',
            'nhijos.min' => 'El número de hijos debe ser mayor o igual a 0',
            'dpto.required' => 'El departamento es requerido',
            'dpto.in' => 'El departamento seleccionado es inválido',
            'sede.required' => 'La sede es requerida',
            'sede.in' => 'La sede seleccionada es inválida',
        ]);

        // Actualizar los campos
        $empleado->cedula = $request->input('cedula');
        $empleado->nombre = $request->input('nombre');
        $empleado->apellido = $request->input('apellido');
        $empleado->fecha_nacimiento = $request->input('nacimiento');
        $empleado->genero = $request->input('genero');
        $empleado->correo = $request->input('email');
        $empleado->fecha_entrada = $request->input('ingreso');
        $empleado->celular = $request->input('telefono');
        $empleado->estado_civil = $request->input('estado-civil');
        $empleado->nro_hijos = $request->input('nhijos');
        $empleado->id_departamento = $request->input('dpto');
        $empleado->id_sede = $request->input('sede');
        $empleado->fecha_actualizacion = now();
        $empleado->actualizado_por = auth('g_administradores')->user()->id_admin;
        $empleado->save();

        return redirect()->route('editar-empleado', $empleado->id_empleado)->with('success', 'Empleado actualizado correctamente.');
    }

    public function eliminarEmpleado($id_empleado)
    {
        $empleado = Empleados::where('id_empleado', $id_empleado)->first();

        if (!$empleado) {
            return redirect()->route('empleados')->with('error', 'Empleado no encontrado.');
        }

        $empleado->fecha_actualizacion = now();
        $empleado->actualizado_por = auth('g_administradores')->user()->id_admin;
        $empleado->activo = 0;
        $empleado->save();

        return redirect()->route('empleados')->with('success', 'Empleado Eliminado correctamente.');
    }
}
