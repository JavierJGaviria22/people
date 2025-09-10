<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirección según el guardia
                if ($guard === 'g_administradores') {
                    return redirect('/admin'); // Redirigir a /admin si es admin
                } elseif ($guard === 'g_usuarios') {
                    return redirect('/'); // Redirigir a / si es usuario
                }
            }
        }

        return $next($request);
    }
}
