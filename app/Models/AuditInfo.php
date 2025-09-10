<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditInfo extends Model
{
    use HasFactory;

    protected $table = 'audit_info';
    protected $primaryKey = 'id_audit';

    public $timestamps = false;
}
