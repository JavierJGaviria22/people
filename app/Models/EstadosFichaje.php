<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosFichaje extends Model
{
    use HasFactory;

    protected $table = 'pd_estados';
    protected $primaryKey = 'id_estado';

    // no existen created_at y updated_at
    public $timestamps = false;
}
