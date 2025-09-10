<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleados;

class ZonasHorarias extends Model
{
    use HasFactory;

    protected $table = 'zonas_horarias';
    protected $primaryKey = 'id_zona_horaria';

    /*Crear relacion de uno a muchos con empleados
    public function empleados()
    {
        return $this->hasMany(Empleados::class, 'id_departamento');
    }*/
}
