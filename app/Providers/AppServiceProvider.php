<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Permisos;
use Illuminate\Support\Facades\DB;
use App\Observers\PermisosObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    

public function boot()
{
    // Deshabilitar ONLY_FULL_GROUP_BY en la sesión de MySQL
    DB::statement('SET SESSION sql_mode = REPLACE(@@sql_mode, "ONLY_FULL_GROUP_BY", "")');
}
}
