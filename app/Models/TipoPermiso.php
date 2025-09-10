<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPermiso extends Model
{
    use HasFactory;

    protected $table = 'tipo_permiso';
    protected $primaryKey = 'id_tipo_permiso';

    // no existen created_at y updated_at
    public $timestamps = false;

}
