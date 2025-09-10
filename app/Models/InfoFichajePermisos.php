<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoFichajePermisos extends Model
{
    use HasFactory;

    protected $table = 'pd_info_permisos';
    protected $primaryKey = 'id_pd_info_permisos';

    // no existen created_at y updated_at
    public $timestamps = false;
}
