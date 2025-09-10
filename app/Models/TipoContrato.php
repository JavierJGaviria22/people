<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    use HasFactory;

    protected $table = 'tipo_contrato';
    protected $primaryKey = 'id_tipo_contrato';

    // no existen created_at y updated_at
    public $timestamps = false;

}
