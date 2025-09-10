<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresas;

class Administradores extends Authenticatable 
{
    use HasFactory;

    protected $table = 'administradores';

    protected $fillable = [
        'correo',
        'password',
        'activo',
        'empresa',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'correo'; // Campo que se utilizará para identificar al usuario
    }

    public function getAuthPassword()
    {
        return $this->password; // Campo de la contraseña
    }

    public function setContrasenaAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    //Crear relacion de uno a muchos con empresas
    public function empresas()
    {
        return $this->belongsTo(Empresas::class, 'id_admin', 'creado_por');
    }

}
