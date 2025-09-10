<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class configAdminController extends Controller
{
    public function index()
    {
        return view('admin.configuracion');
    }
}
