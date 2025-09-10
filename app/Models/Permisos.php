<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $primaryKey = 'id_permiso';
    public $incrementing = true;
    protected $keyType = 'int'; 
    public $timestamps = false;

    public function tipoPermiso()
    {
        return $this->belongsTo(TipoPermiso::class, 'id_tipo_permiso', 'id_tipo_permiso');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleados::class, 'id_empleado', 'id_empleado');
    }
}
