<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleados;

class Departamentos extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';

    public $timestamps = false;

    //Crear relacion de uno a muchos con empleados
    public function empleados()
    {
        return $this->hasMany(Empleados::class, 'id_departamento');
    }
}
