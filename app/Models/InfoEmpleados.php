<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoEmpleados extends Model
{
    use HasFactory;

    protected $table = 'z_info_empleados';

    // no existen created_at y updated_at
    public $timestamps = false;

}
