<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Festivos extends Model
{
    use HasFactory;

    protected $table = 'festivos'; 

    protected $primaryKey = 'id_festivo';

    public $timestamps = false;

}
