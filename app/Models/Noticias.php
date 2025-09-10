<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticias extends Model
{
    use HasFactory;

    protected $table = 'noticias';
    protected $primaryKey = 'id_noticia';

    // no existen created_at y updated_at
    public $timestamps = false;

}
