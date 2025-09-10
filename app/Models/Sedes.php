<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleados;

class Sedes extends Model
{
    use HasFactory;

    protected $table = 'sedes';
    protected $primaryKey = 'id_sede';

    public $timestamps = false;

    /*Crear relacion de uno a muchos con empleados
    public function empleados()
    {
        return $this->hasMany(Empleados::class, 'id_departamento');
    }*/
}
