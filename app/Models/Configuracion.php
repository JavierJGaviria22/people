<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresas;

class Configuracion extends Authenticatable 
{
    use HasFactory;

    protected $table = 'configuracion_vacaciones';

    protected $primaryKey = 'id_configuracion';

    public $timestamps = false;

}
