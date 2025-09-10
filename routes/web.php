<?php
//date_default_timezone_set('America/Bogota');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\loginAdminController;
use App\Http\Controllers\usuarios\homeController;
use App\Http\Controllers\usuarios\calendarioController;
use App\Http\Controllers\admin\homeAdminController;
use App\Http\Controllers\usuarios\mostrarInfoController;
use App\Http\Controllers\usuarios\permisosController;
use App\Http\Controllers\usuarios\horariosController;
use App\Http\Controllers\usuarios\fichajeController;
use App\Http\Controllers\admin\empleadosAdminController;
use App\Http\Controllers\admin\noticiasAdminController;
use App\Http\Controllers\admin\contratosAdminController;
use App\Http\Controllers\admin\configAdminController;
use App\Http\Controllers\admin\departamentosAdminController;
use App\Http\Controllers\admin\festivosAdminController;
use App\Http\Controllers\admin\reportePonchadorController;
use App\Http\Controllers\usuarios\reporteAsistenciaController;
use App\Http\Controllers\admin\sedesAdminController;
use App\Http\Controllers\admin\tipoContratoAdminController;
use App\Http\Controllers\admin\tipoPermisoAdminController;
use App\Http\Controllers\admin\vacacionesAdminController;
use App\Http\Controllers\admin\nominaController;
use App\Models\Departamentos;
use App\Models\ReportePonchador;
use Illuminate\Support\Facades\Auth;

Route::prefix('test')->group(function () {

    Route::get('/testi', [homeController::class, 'testi'])->name('/testi');
});
// Route::get('nomina/{id_empleado}/{fecha}/edit', [nominaController::class, 'edit'])->name('nomina.edit');
/*Funcion para agrupar rutas protegidas por middleware
Route::middleware('auth:g_administradores')->group(function () { "aqui van las rutas" } */

// Rutas usuarios
Route::get('/', [homeController::class, 'index'])->name('/')->middleware('auth:g_usuarios');
Route::post('newPass', [homeController::class, 'actualizarPassword'])->name('newPass')->middleware('auth:g_usuarios');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest:g_usuarios');
Route::post('login', [LoginController::class, 'iniciarSesion']);
Route::post('logout', [LoginController::class, 'cerrarSesion'])->name('logout');

Route::get('preguntas-frecuentes', [mostrarInfoController::class, 'pagesFaq'])->name('faq')->middleware('auth:g_usuarios');

Route::get('mi-perfil', [mostrarInfoController::class, 'userPerfil'])->name('mi-perfil')->middleware('auth:g_usuarios');

Route::get('calendario', [calendarioController::class, 'index'])->name('calendario')->middleware('auth:g_usuarios');

Route::get('horarios', [horariosController::class, 'index'])->name('horarios.index');
Route::get('nuevo-horario', [horariosController::class, 'create'])->name('horarios.create');
Route::get('editar-horario', [horariosController::class, 'create'])->name('horarios.editar');
Route::post('asignar-horario', [horariosController::class, 'store'])->name('horarios.store');
Route::post('crear-horario', [horariosController::class, 'crear'])->name('horarios.crear');
Route::post('actualizar-horario', [horariosController::class, 'actualizar'])->name('horarios.actualizar');
Route::get('horarios/{id_horario}/edit', [horariosController::class, 'edit'])->name('horarios.edit');
Route::post('horarios/{id_horario}', [horariosController::class, 'update'])->name('horarios.update');
Route::get('horarios/{id_horario}/delete', [horariosController::class, 'delete'])->name('horarios.delete');
// Route::resource('horarios', horariosController::class);

Route::get('permisos', [permisosController::class, 'index'])->name('permisos')->middleware('auth:g_usuarios');
Route::get('mis-permisos', [permisosController::class, 'misPermisos'])->name('mis-permisos')->middleware('auth:g_usuarios');
Route::get('nuevo-permiso', [permisosController::class, 'nuevoPermiso'])->name('nuevo-permiso')->middleware('auth:g_usuarios');
Route::post('nuevo-permiso', [permisosController::class, 'agregarPermiso']);
Route::get('editar-permiso/{id_permiso}', [permisosController::class, 'editarPermiso'])->name('editar-permiso')->middleware('auth:g_usuarios');
Route::post('editar-permiso/{id_permiso}', [permisosController::class, 'actualizarPermiso']);
Route::get('eliminar-permiso/{id_permiso}', [permisosController::class, 'eliminarPermiso'])->name('eliminar-permiso');
Route::post('actuar-permiso/{id_permiso}/procesar', [permisosController::class, 'actuarPermiso'])->name('procesar-permiso');

Route::get('reporte-horas-l', [reporteAsistenciaController::class, 'index'])->name('reporte-horas-l');
Route::get('reporte-detalle/{id_empleado}/{fecha}/show', [reporteAsistenciaController::class, 'show'])->name('reporte-detalle');

Route::middleware(['auth:g_usuarios', 'timezone'])->group(function () {
    // Las rutas aquí estarán protegidas por ambos middlewares
    Route::get('fichaje', [fichajeController::class, 'index'])->name('fichaje')->middleware('auth:g_usuarios');
    Route::get('fichaje-deshacer/{id_pd_info}', [fichajeController::class, 'deshacerUltimoEstado'])->name('fichaje-deshacer')->middleware('auth:g_usuarios');
    Route::get('fichaje-deshacer-permiso/{id_pd_info_permisos}', [fichajeController::class, 'deshacerUltimoEstadoPermiso'])->name('fichaje-deshacer-permiso')->middleware('auth:g_usuarios');
    Route::post('fichaje', [fichajeController::class, 'agregarInfo']);
    Route::post('fichaje/correccion', [fichajeController::class, 'agregarCorreccion'])->name('fichaje.correccion');;
    Route::post('fichaje/ausencia', [fichajeController::class, 'agregarAusencia'])->name('fichaje.ausencia');;
    Route::post('fichajePermiso', [fichajeController::class, 'agregarInfoPermiso'])->name('fichajePermiso');
});

// Fin rutas usuario

// Rutas admin
Route::prefix('admin')->group(function () {

    Route::get('login', [loginAdminController::class, 'showLoginFormAdmin'])->name('A-login')->middleware('guest:g_administradores');
    Route::post('login', [loginAdminController::class, 'iniciarSesionAdmin']);
    Route::post('logout', [loginAdminController::class, 'cerrarSesionAdmin'])->name('A-logout');

    Route::get('/', [homeAdminController::class, 'index'])->name('/admin')->middleware('auth:g_administradores');
    Route::get('contratos-por-vencer', [homeAdminController::class, 'contratos'])->name('contratos-por-vencer')->middleware('auth:g_administradores');

    Route::get('configuracion', [configAdminController::class, 'index'])->name('config')->middleware('auth:g_administradores');
    Route::resource('departamentos', departamentosAdminController::class)->middleware('auth:g_administradores');
    Route::resource('festivos', festivosAdminController::class)->middleware('auth:g_administradores');
    Route::resource('sedes', sedesAdminController::class)->middleware('auth:g_administradores');
    Route::resource('tipo-contratos', tipoContratoAdminController::class)->middleware('auth:g_administradores');
    Route::resource('tipo-permisos', tipoPermisoAdminController::class)->middleware('auth:g_administradores');
    Route::resource('vacaciones', vacacionesAdminController::class)->middleware('auth:g_administradores');

    Route::get('empleados', [empleadosAdminController::class, 'mostrar'])->name('empleados')->middleware('auth:g_administradores');
    Route::get('nuevo-empleado', [empleadosAdminController::class, 'nuevoEmpleado'])->name('nuevo-empleado')->middleware('auth:g_administradores');
    Route::post('nuevo-empleado', [empleadosAdminController::class, 'agregarEmpleado'])->name('agregar-empleado')->middleware('auth:g_administradores');
    Route::get('editar-empleado/{id_empleado}', [empleadosAdminController::class, 'editarEmpleado'])->name('editar-empleado');
    Route::post('editar-empleado/{id_empleado}', [empleadosAdminController::class, 'actualizarEmpleado']);
    Route::get('eliminar-empleado/{id_empleado}', [empleadosAdminController::class, 'eliminarEmpleado'])->name('eliminar-empleado')->middleware('auth:g_administradores');

    Route::resource('noticias', noticiasAdminController::class)->middleware('auth:g_administradores');
    Route::resource('contratos', contratosAdminController::class)->middleware('auth:g_administradores');

    Route::resource('reporte-horas', reportePonchadorController::class)->middleware('auth:g_administradores');
    Route::get('nomina', [nominaController::class, 'index'])->name('nomina.index');
    Route::post('nomina/update', [nominaController::class, 'update'])->name('nomina.update');
    Route::get('nomina/delete/{id_estado}', [nominaController::class, 'show'])->name('nomina.show');
    Route::get('nomina/{id_empleado}/{fecha}/edit', [nominaController::class, 'edit'])->name('nomina.edit');
    Route::get('nomina/inconsistencias/{start_date}/{end_date}', [nominaController::class, 'showInconsistencias'])->name('nomina.showInconsistencias');
    Route::post('nomina/agregarEstado', [nominaController::class, 'agregarEstado'])->name('nomina.agregarEstado');

    Route::get('reportes/audit-log', [reportePonchadorController::class, 'audit_log'])->name('nomina.audit-log');

    Route::get('horariosA', [horariosController::class, 'index'])->name('horariosA.index');
    
    Route::get('info-pto', [vacacionesAdminController::class, 'showReporte'])->name('info-pto');

    Route::get('detalle-pto/{id_empleado}', [vacacionesAdminController::class, 'showpto'])->name('detalle-pto');

    Route::get('nomina/ubicacion/{id_pd_info}', [nominaController::class, 'showubicacion'])->name('nomina.ubicacion');

    Route::get('reportes/dashboards', function(){
        return view('admin.dashboards');
    })->name('dashboards')->middleware('auth:g_administradores');

});
//Fin rutas admin
  