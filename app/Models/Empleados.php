<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departamentos;
use App\Models\Administradores;

class Empleados extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';

    // no existen created_at y updated_at
    public $timestamps = false;

    //Crear relacion de uno a muchos con departamentos
    public function departamento()
    {
        return $this->belongsTo(Departamentos::class, 'id_departamento', 'id_departamento');
    }

    public function administradores()
    {
        return $this->belongsTo(Administradores::class, 'creado_por', 'id_admin');
    }
}
