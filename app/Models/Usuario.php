<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Empleados;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'usuario',
        'contrasena',
        'activo',
    ];

    public $timestamps = false;
    protected $primaryKey = 'id_empleado';

    protected $hidden = [
        'contrasena',
    ];

    public function getAuthIdentifierName()
    {
        return 'usuario'; // Campo que se utilizará para identificar al usuario
    }

    public function getAuthPassword()
    {
        return $this->contrasena; // Campo de la contraseña
    }

    public function setContrasenaAttribute($contrasena)
    {
        $this->attributes['contrasena'] = bcrypt($contrasena);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleados::class, 'id_empleado', 'id_empleado');
    }
}
