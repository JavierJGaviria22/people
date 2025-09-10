<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    use HasFactory;

    protected $table = 'pd_horarios';
    protected $primaryKey = 'id_horario';

    // no existen created_at y updated_at
    public $timestamps = false;

}
