<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoFichaje extends Model
{
    use HasFactory;

    protected $table = 'pd_info';
    protected $primaryKey = 'id_pd_info';

    // no existen created_at y updated_at
    public $timestamps = false;
}
