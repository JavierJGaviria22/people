<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    use HasFactory;

    protected $table = 'pd_observaciones';
    protected $primaryKey = 'id_observacion';

    public $timestamps = false;
}
