<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ZonasHorarias;

class SetTimezone
{
    public function handle($request, Closure $next)
    {
        // Verificar si el usuario esta autenticado usando el guard 'g_usuarios'
        if (Auth::guard('g_usuarios')->check()) {
            $sede = Auth::guard('g_usuarios')->user()->empleado->id_sede;

            $timezone = ZonasHorarias::join('sedes', 'sedes.id_zona_horaria', '=', 'zonas_horarias.id_zona_horaria')
            ->where('sedes.id_sede', $sede)
            ->value('zonas_horarias.zona_horaria');

            if ($sede && $timezone) {
                // Establecer la zona horaria para la aplicacion y Carbon
                //config(['app.timezone' => $sede->timezone]);
                date_default_timezone_set($timezone);
                Carbon::setLocale('es');  // Opcional: Ajustar el locale de Carbon si es necesario
            }
        }

        return $next($request);
    }
}
